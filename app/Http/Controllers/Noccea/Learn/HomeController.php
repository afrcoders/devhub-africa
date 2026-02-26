<?php

namespace App\Http\Controllers\Noccea\Learn;

use App\Http\Controllers\Controller;
use App\Models\Noccea\Learn\Course;
use App\Services\CourseImageService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get platform statistics
        $stats = [
            'total_courses' => Course::count(),
            'total_students' => \DB::table('course_enrollments')->distinct('user_id')->count(),
            'total_lessons' => \DB::table('course_lessons')->count(),
            'total_completions' => \DB::table('lesson_completions')->count(),
        ];

        // Get featured courses (random 6 courses)
        $featuredCourses = Course::with(['modules.lessons'])
        ->inRandomOrder()
        ->take(6)
        ->get()
        ->map(function($course) {
            $totalLessons = 0;
            foreach ($course->modules as $module) {
                $totalLessons += $module->lessons->count();
            }
            $course->total_lessons = $totalLessons;
            $course->students_count = $course->enrollments()->count();
            return $course;
        });

        // Get recent Q&A forum questions
        $recentQuestions = \App\Models\Noccea\Learn\ForumQuestion::with(['user', 'answers'])
            ->latest()
            ->take(5)
            ->get();

        // Get course categories with counts
        $categories = Course::select('category', \DB::raw('count(*) as count'))
            ->groupBy('category')
            ->orderByDesc('count')
            ->take(6)
            ->get();

        return view('noccea.learn.home', compact('stats', 'featuredCourses', 'recentQuestions', 'categories'));
    }

    public function login(Request $request)
    {
        // Get return URL from query param or use the referrer (previous page)
        $returnUrl = $request->input('return') ?? url()->previous();

        // If previous URL is the login page itself, use home instead
        if ($returnUrl === $request->fullUrl() || str_contains($returnUrl, '/login')) {
            $returnUrl = route('noccea.learn.home');
        }

        // Clean up the return URL to remove any nonce parameters
        $returnUrl = $this->cleanUrl($returnUrl);

        // Redirect to ID service login with return URL
        return redirect()->away('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
    }

    public function logout(Request $request)
    {
        // Always return to home page after logout
        $returnUrl = route('noccea.learn.home');

        // Redirect to ID service logout with return URL
        return redirect()->away('https://' . config('domains.africoders.id') . '/logout?return=' . urlencode($returnUrl));
    }

    /**
     * Clean up URL by removing nonce parameters.
     */
    private function cleanUrl(string $url): string
    {
        $parsed = parse_url($url);
        $path = $parsed['path'] ?? '/';
        $scheme = $parsed['scheme'] ?? 'https';
        $host = $parsed['host'] ?? request()->getHost();

        // Reconstruct URL without query string (which may contain nonce)
        return $scheme . '://' . $host . $path;
    }

    public function dashboard()
    {
        $user = auth()->user();

        // Get user's enrolled courses with progress
        $enrolledCourses = $user->enrollments()
            ->with(['course.modules.lessons'])
            ->latest()
            ->get()
            ->map(function($enrollment) use ($user) {
                $course = $enrollment->course;
                $totalLessons = $course->modules->sum(function($module) {
                    return $module->lessons->count();
                });
                $completedLessons = $user->completedLessons()
                    ->whereIn('lesson_id', $course->modules->pluck('lessons')->flatten()->pluck('id'))
                    ->count();

                $enrollment->total_lessons = $totalLessons;
                $enrollment->completed_lessons = $completedLessons;
                $enrollment->progress_percentage = $totalLessons > 0
                    ? round(($completedLessons / $totalLessons) * 100)
                    : 0;

                return $enrollment;
            });

        // Stats
        $stats = [
            'enrolled' => $enrolledCourses->count(),
            'completed' => $enrolledCourses->where('progress_percentage', 100)->count(),
            'in_progress' => $enrolledCourses->where('progress_percentage', '>', 0)->where('progress_percentage', '<', 100)->count(),
            'discussion_posts' => 0, // TODO: Add forum posts count
        ];

        // Get featured courses from database
        $featuredCourses = Course::with('modules.lessons')
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('noccea.learn.dashboard', compact('enrolledCourses', 'stats', 'featuredCourses'));
    }

    /**
     * Get all available courses
     */
    private function getAllCourses()
    {
        $courses = [
            // Web Development
            (object)[
                'id' => 1,
                'title' => 'Advanced Web Development with React',
                'description' => 'Master React.js and build modern single-page applications with hooks, context API, and performance optimization.',
                'long_description' => 'This comprehensive course covers advanced React concepts including custom hooks, performance optimization, state management, and real-world project development. You\'ll learn best practices for building scalable single-page applications.',
                'category' => 'Web Development',
                'level' => 'Advanced',
                'rating' => 4.8,
                'reviews' => 342,
                'students' => 5420,
                'price' => 49950,
                'duration' => '8 weeks',
                'lessons' => 96,
                'image_color' => 'from-blue-500 to-cyan-600',
                'instructor' => 'John Developer',
                'topics' => ['React Hooks', 'State Management', 'Performance', 'Testing', 'Deployment'],
                'requirements' => ['JavaScript fundamentals', 'HTML/CSS knowledge', 'Understanding of ES6+']
            ],
            (object)[
                'id' => 2,
                'title' => 'Full Stack Development: MERN Stack',
                'description' => 'Learn MongoDB, Express, React, and Node.js to become a full-stack JavaScript developer.',
                'long_description' => 'Complete guide to becoming a full-stack developer using the MERN stack. Build production-ready applications with database design, API development, authentication, and deployment.',
                'category' => 'Web Development',
                'level' => 'Intermediate',
                'rating' => 4.7,
                'reviews' => 287,
                'students' => 4120,
                'price' => 44950,
                'duration' => '10 weeks',
                'lessons' => 120,
                'image_color' => 'from-green-500 to-emerald-600',
                'instructor' => 'Sarah Code',
                'topics' => ['MongoDB', 'Express', 'React', 'Node.js', 'Authentication'],
                'requirements' => ['JavaScript knowledge', 'Basic web development experience']
            ],
            (object)[
                'id' => 3,
                'title' => 'Vue.js 3 Mastery Course',
                'description' => 'Deep dive into Vue.js 3 with composition API, Pinia for state management, and real-world projects.',
                'long_description' => 'Master Vue.js 3 from basics to advanced patterns. Learn the composition API, create reusable components, manage state with Pinia, and build real-world applications.',
                'category' => 'Web Development',
                'level' => 'Intermediate',
                'rating' => 4.6,
                'reviews' => 198,
                'students' => 2890,
                'price' => 39950,
                'duration' => '6 weeks',
                'lessons' => 72,
                'image_color' => 'from-emerald-500 to-teal-600',
                'instructor' => 'Emma Vue',
                'topics' => ['Vue 3', 'Composition API', 'Pinia', 'Component Design'],
                'requirements' => ['JavaScript knowledge', 'React experience helpful']
            ],

            // Mobile Development
            (object)[
                'id' => 4,
                'title' => 'iOS Development with Swift',
                'description' => 'Build native iOS applications using Swift, SwiftUI, and Core Data. Create production-ready apps.',
                'long_description' => 'Learn to build native iOS applications with Swift and SwiftUI. Master app architecture, data persistence with Core Data, and publish apps to the App Store.',
                'category' => 'Mobile Development',
                'level' => 'Intermediate',
                'rating' => 4.9,
                'reviews' => 256,
                'students' => 3560,
                'price' => 47450,
                'duration' => '9 weeks',
                'lessons' => 108,
                'image_color' => 'from-purple-500 to-pink-600',
                'instructor' => 'Alex Swift',
                'topics' => ['Swift', 'SwiftUI', 'Core Data', 'App Store Deployment'],
                'requirements' => ['Mac with Xcode', 'Basic programming knowledge']
            ],
            (object)[
                'id' => 5,
                'title' => 'Android Development with Kotlin',
                'description' => 'Master Kotlin and Android SDK to develop modern Android applications with best practices.',
                'long_description' => 'Become an Android developer using Kotlin. Learn modern Android architecture, build responsive UIs, handle data, and publish apps to Google Play Store.',
                'category' => 'Mobile Development',
                'level' => 'Intermediate',
                'rating' => 4.7,
                'reviews' => 212,
                'students' => 2950,
                'price' => 44950,
                'duration' => '8 weeks',
                'lessons' => 96,
                'image_color' => 'from-green-600 to-lime-600',
                'instructor' => 'Mike Android',
                'topics' => ['Kotlin', 'Android SDK', 'Material Design', 'Database'],
                'requirements' => ['Java or programming knowledge', 'Linux/Mac/Windows']
            ],
            (object)[
                'id' => 6,
                'title' => 'React Native: Cross-Platform Mobile Apps',
                'description' => 'Build iOS and Android apps using React Native. Share code across platforms.',
                'long_description' => 'Write once, run everywhere. Build iOS and Android applications using React Native, sharing code across platforms and reducing development time.',
                'category' => 'Mobile Development',
                'level' => 'Advanced',
                'rating' => 4.8,
                'reviews' => 189,
                'students' => 2640,
                'price' => 49950,
                'duration' => '10 weeks',
                'lessons' => 120,
                'image_color' => 'from-blue-600 to-indigo-600',
                'instructor' => 'Lisa Mobile',
                'topics' => ['React Native', 'iOS', 'Android', 'Navigation', 'APIs'],
                'requirements' => ['React knowledge', 'JavaScript proficiency']
            ],

            // Data Science & Analytics
            (object)[
                'id' => 7,
                'title' => 'Data Science with Python',
                'description' => 'Learn Python, pandas, NumPy, scikit-learn, and data visualization. Analyze real-world datasets.',
                'long_description' => 'Start your data science journey with Python. Learn data manipulation, analysis, visualization, and build machine learning models using industry-standard libraries.',
                'category' => 'Data Science',
                'level' => 'Beginner',
                'rating' => 4.8,
                'reviews' => 421,
                'students' => 6280,
                'price' => 39950,
                'duration' => '6 weeks',
                'lessons' => 72,
                'image_color' => 'from-orange-500 to-red-600',
                'instructor' => 'Dr. Analytics',
                'topics' => ['Python', 'Pandas', 'NumPy', 'Scikit-learn', 'Data Visualization'],
                'requirements' => ['Basic Python knowledge', 'Mathematics fundamentals']
            ],
            (object)[
                'id' => 8,
                'title' => 'Statistical Analysis & Probability',
                'description' => 'Master statistics, hypothesis testing, and probability theory for data analysis and research.',
                'long_description' => 'Deep understanding of statistics and probability. Learn hypothesis testing, distributions, statistical inference, and apply these concepts to real data.',
                'category' => 'Data Science',
                'level' => 'Intermediate',
                'rating' => 4.6,
                'reviews' => 156,
                'students' => 1890,
                'price' => 37450,
                'duration' => '7 weeks',
                'lessons' => 84,
                'image_color' => 'from-indigo-500 to-purple-600',
                'instructor' => 'Prof. Stats',
                'topics' => ['Probability', 'Hypothesis Testing', 'Distributions', 'Regression'],
                'requirements' => ['Mathematics background', 'Basic statistics knowledge']
            ],
            (object)[
                'id' => 9,
                'title' => 'Advanced Data Visualization',
                'description' => 'Create stunning visualizations with D3.js, Plotly, and Tableau. Communicate data insights effectively.',
                'long_description' => 'Master the art of data visualization. Learn D3.js for interactive plots, Plotly for quick visualizations, and Tableau for business intelligence dashboards.',
                'category' => 'Data Science',
                'level' => 'Intermediate',
                'rating' => 4.7,
                'reviews' => 203,
                'students' => 2450,
                'price' => 42450,
                'duration' => '5 weeks',
                'lessons' => 60,
                'image_color' => 'from-pink-500 to-rose-600',
                'instructor' => 'Viz Master',
                'topics' => ['D3.js', 'Plotly', 'Tableau', 'Dashboard Design'],
                'requirements' => ['Data analysis basics', 'JavaScript familiarity helpful']
            ],

            // Artificial Intelligence & Machine Learning
            (object)[
                'id' => 10,
                'title' => 'Machine Learning Fundamentals',
                'description' => 'Introduction to supervised and unsupervised learning, model evaluation, and scikit-learn.',
                'long_description' => 'Get started with machine learning. Learn supervised learning, unsupervised learning, model selection, evaluation metrics, and build your first ML projects.',
                'category' => 'Artificial Intelligence & ML',
                'level' => 'Beginner',
                'rating' => 4.8,
                'reviews' => 512,
                'students' => 8940,
                'price' => 44950,
                'duration' => '8 weeks',
                'lessons' => 96,
                'image_color' => 'from-indigo-600 to-blue-600',
                'instructor' => 'Dr. AI',
                'topics' => ['Supervised Learning', 'Unsupervised Learning', 'Model Evaluation', 'Feature Engineering'],
                'requirements' => ['Python knowledge', 'Mathematics basics', 'Statistics knowledge']
            ],
            (object)[
                'id' => 11,
                'title' => 'Deep Learning & Neural Networks',
                'description' => 'Deep dive into neural networks, CNNs, RNNs, transformers using TensorFlow and PyTorch.',
                'long_description' => 'Master deep learning with TensorFlow and PyTorch. Learn neural network architectures, CNNs for vision, RNNs for sequences, and transformers for NLP.',
                'category' => 'Artificial Intelligence & ML',
                'level' => 'Advanced',
                'rating' => 4.9,
                'reviews' => 378,
                'students' => 4560,
                'price' => 64950,
                'duration' => '12 weeks',
                'lessons' => 144,
                'image_color' => 'from-violet-600 to-purple-600',
                'instructor' => 'Prof. Deep Learning',
                'topics' => ['Neural Networks', 'CNNs', 'RNNs', 'Transformers', 'TensorFlow', 'PyTorch'],
                'requirements' => ['Machine learning basics', 'Python proficiency', 'Linear algebra knowledge']
            ],
            (object)[
                'id' => 12,
                'title' => 'Natural Language Processing (NLP)',
                'description' => 'Text processing, sentiment analysis, transformers, BERT, and building language models.',
                'long_description' => 'Master NLP with transformers and BERT. Build chatbots, sentiment analyzers, text classifiers, and language models using state-of-the-art techniques.',
                'category' => 'Artificial Intelligence & ML',
                'level' => 'Advanced',
                'rating' => 4.8,
                'reviews' => 298,
                'students' => 3120,
                'price' => 59950,
                'duration' => '10 weeks',
                'lessons' => 120,
                'image_color' => 'from-cyan-600 to-blue-600',
                'instructor' => 'NLP Expert',
                'topics' => ['NLP Basics', 'Transformers', 'BERT', 'Text Classification', 'Sentiment Analysis'],
                'requirements' => ['Deep learning knowledge', 'Python proficiency']
            ],
            (object)[
                'id' => 13,
                'title' => 'Computer Vision Masterclass',
                'description' => 'Image processing, object detection, semantic segmentation, and building vision applications.',
                'long_description' => 'Become a computer vision expert. Learn image processing, object detection with YOLO, semantic segmentation, and build real-world vision applications.',
                'category' => 'Artificial Intelligence & ML',
                'level' => 'Advanced',
                'rating' => 4.7,
                'reviews' => 267,
                'students' => 2780,
                'price' => 62450,
                'duration' => '11 weeks',
                'lessons' => 132,
                'image_color' => 'from-yellow-600 to-orange-600',
                'instructor' => 'Vision Pro',
                'topics' => ['Image Processing', 'Object Detection', 'Segmentation', 'Face Recognition'],
                'requirements' => ['Deep learning basics', 'Python knowledge']
            ],
            (object)[
                'id' => 14,
                'title' => 'Generative AI & Large Language Models',
                'description' => 'Prompt engineering, fine-tuning LLMs, building applications with ChatGPT and other LLMs.',
                'long_description' => 'Work with cutting-edge generative AI. Learn prompt engineering, fine-tune language models, and build applications using ChatGPT, GPT-4, and open-source models.',
                'category' => 'Artificial Intelligence & ML',
                'level' => 'Advanced',
                'rating' => 4.9,
                'reviews' => 456,
                'students' => 6210,
                'price' => 69950,
                'duration' => '10 weeks',
                'lessons' => 120,
                'image_color' => 'from-red-600 to-pink-600',
                'instructor' => 'AI Visionary',
                'topics' => ['Prompt Engineering', 'LLM Fine-tuning', 'Embeddings', 'RAG Systems'],
                'requirements' => ['NLP fundamentals', 'API usage experience']
            ],
            (object)[
                'id' => 15,
                'title' => 'Reinforcement Learning & Game AI',
                'description' => 'Q-learning, policy gradients, game-playing AI, and autonomous decision-making systems.',
                'long_description' => 'Learn reinforcement learning to build intelligent agents. Master Q-learning, policy gradients, and create game-playing AI and autonomous decision systems.',
                'category' => 'Artificial Intelligence & ML',
                'level' => 'Advanced',
                'rating' => 4.6,
                'reviews' => 189,
                'students' => 1560,
                'price' => 54950,
                'duration' => '9 weeks',
                'lessons' => 108,
                'image_color' => 'from-lime-600 to-green-600',
                'instructor' => 'Game AI Dev',
                'topics' => ['Q-Learning', 'Policy Gradients', 'Game AI', 'Markov Chains'],
                'requirements' => ['Machine learning basics', 'Python proficiency']
            ],

            // Cloud & DevOps
            (object)[
                'id' => 16,
                'title' => 'AWS Solutions Architect',
                'description' => 'Master AWS services, architecture design, scalability, and prepare for AWS certification.',
                'long_description' => 'Design scalable cloud architecture on AWS. Learn EC2, S3, RDS, Lambda, and prepare for AWS Solutions Architect certification.',
                'category' => 'Cloud Computing',
                'level' => 'Intermediate',
                'rating' => 4.8,
                'reviews' => 334,
                'students' => 4890,
                'price' => 47450,
                'duration' => '8 weeks',
                'lessons' => 96,
                'image_color' => 'from-orange-600 to-yellow-600',
                'instructor' => 'Cloud Expert',
                'topics' => ['EC2', 'S3', 'RDS', 'Lambda', 'VPC', 'CloudFront'],
                'requirements' => ['AWS basics', 'System administration knowledge']
            ],
            (object)[
                'id' => 17,
                'title' => 'Kubernetes & Container Orchestration',
                'description' => 'Docker, Kubernetes, microservices architecture, and deploying containerized applications.',
                'long_description' => 'Master containerization with Docker and orchestration with Kubernetes. Build microservices and deploy to production environments.',
                'category' => 'Cloud Computing',
                'level' => 'Intermediate',
                'rating' => 4.7,
                'reviews' => 267,
                'students' => 3420,
                'price' => 42450,
                'duration' => '7 weeks',
                'lessons' => 84,
                'image_color' => 'from-blue-600 to-cyan-600',
                'instructor' => 'K8s Master',
                'topics' => ['Docker', 'Kubernetes', 'Helm', 'Microservices'],
                'requirements' => ['Linux basics', 'Docker knowledge']
            ],
            (object)[
                'id' => 18,
                'title' => 'DevOps & CI/CD Pipelines',
                'description' => 'Jenkins, GitLab CI, GitHub Actions, and building automated deployment pipelines.',
                'long_description' => 'Build automated deployment pipelines. Learn Jenkins, GitLab CI, GitHub Actions, and implement continuous integration and continuous deployment.',
                'category' => 'Cloud Computing',
                'level' => 'Intermediate',
                'rating' => 4.6,
                'reviews' => 198,
                'students' => 2640,
                'price' => 39950,
                'duration' => '6 weeks',
                'lessons' => 72,
                'image_color' => 'from-purple-600 to-pink-600',
                'instructor' => 'DevOps Lead',
                'topics' => ['Jenkins', 'GitLab CI', 'GitHub Actions', 'Infrastructure as Code'],
                'requirements' => ['Linux knowledge', 'Git proficiency']
            ],

            // Backend Development
            (object)[
                'id' => 19,
                'title' => 'Node.js Backend Development',
                'description' => 'Express.js, RESTful APIs, database design, authentication, and deployment.',
                'long_description' => 'Build scalable backends with Node.js. Learn Express.js, design RESTful APIs, implement authentication, and deploy production applications.',
                'category' => 'Backend Development',
                'level' => 'Intermediate',
                'rating' => 4.8,
                'reviews' => 312,
                'students' => 4120,
                'price' => 42450,
                'duration' => '7 weeks',
                'lessons' => 84,
                'image_color' => 'from-green-600 to-emerald-600',
                'instructor' => 'Node Expert',
                'topics' => ['Express.js', 'REST APIs', 'Authentication', 'Database Design'],
                'requirements' => ['JavaScript knowledge', 'Web concepts understanding']
            ],
            (object)[
                'id' => 20,
                'title' => 'Python Django Framework',
                'description' => 'Build scalable web applications with Django, ORM, authentication, and deployment.',
                'long_description' => 'Master Django framework. Learn ORM, authentication systems, REST APIs, and deploy Django applications to production.',
                'category' => 'Backend Development',
                'level' => 'Intermediate',
                'rating' => 4.7,
                'reviews' => 245,
                'students' => 3210,
                'price' => 39950,
                'duration' => '7 weeks',
                'lessons' => 84,
                'image_color' => 'from-green-600 to-lime-600',
                'instructor' => 'Django Dev',
                'topics' => ['Django', 'Django ORM', 'Authentication', 'REST APIs', 'Deployment'],
                'requirements' => ['Python knowledge', 'Web development basics']
            ],
            (object)[
                'id' => 21,
                'title' => 'Go Programming Language',
                'description' => 'Learn Go for systems programming, microservices, and concurrent applications.',
                'long_description' => 'Learn Go language for building fast, concurrent applications. Master goroutines, channels, and build scalable microservices.',
                'category' => 'Backend Development',
                'level' => 'Intermediate',
                'rating' => 4.6,
                'reviews' => 167,
                'students' => 1890,
                'price' => 37450,
                'duration' => '6 weeks',
                'lessons' => 72,
                'image_color' => 'from-cyan-600 to-blue-600',
                'instructor' => 'Go Master',
                'topics' => ['Go Basics', 'Goroutines', 'Channels', 'Web Servers', 'Microservices'],
                'requirements' => ['Programming experience', 'Familiarity with concurrency concepts']
            ],
        ];

        // Add slugs for SEO-friendly URLs
        foreach ($courses as $course) {
            $course->slug = strtolower(preg_replace(['/\s+/', '/[^a-zA-Z0-9\-]/'], ['-', ''], $course->title)) . '-' . $course->id;
        }

        return $courses;
    }

    public function courses(Request $request)
    {
        // Get courses from database
        $query = Course::query();

        // Filter by category if provided
        $selectedCategory = $request->query('category');
        if ($selectedCategory) {
            $query->where('category', $selectedCategory);
        }

        // Filter by level if provided
        $selectedLevel = $request->query('level');
        if ($selectedLevel) {
            $query->where('level', $selectedLevel);
        }

        $courses = $query->get();

        // Get all unique categories from database
        $categories = Course::select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        // Get all unique levels from database
        $levels = Course::select('level')
            ->distinct()
            ->orderBy('level')
            ->pluck('level');

        // Add generated images to each course
        foreach ($courses as $course) {
            $colorParts = explode(' ', $course->image_color);
            $course->image_url = CourseImageService::generateImageUrl(
                $course->title,
                $course->category,
                $colorParts
            );
        }

        return view('noccea.learn.courses.index', compact('courses', 'categories', 'selectedCategory', 'levels', 'selectedLevel'));
    }


    public function courseDetail($slug)
    {
        $course = \App\Models\Noccea\Learn\Course::where('slug', $slug)->first();

        if (!$course) {
            // Try to find from the hardcoded list
            $courses = $this->getAllCourses();
            $course = collect($courses)->firstWhere("slug", $slug);

            if (!$course) {
                return redirect()->route("noccea.learn.courses.index")->with("error", "Course not found");
            }

            // If found in list, add image and return
            $colorParts = explode(" ", $course->image_color);
            $course->image_url = CourseImageService::generateImageUrl(
                $course->title,
                $course->category,
                $colorParts
            );

            $relatedCourses = collect($courses)
                ->where("category", $course->category)
                ->where("id", "!=", $course->id)
                ->take(3)
                ->map(function ($c) {
                    $colorParts = explode(" ", $c->image_color);
                    $c->image_url = CourseImageService::generateImageUrl(
                        $c->title,
                        $c->category,
                        $colorParts
                    );
                    return $c;
                })
                ->values();

            $isEnrolled = false;
            $firstLessonUrl = null;
            $hasProgress = false;

            return view("noccea.learn.courses.show", compact("course", "relatedCourses", "isEnrolled", "firstLessonUrl", "hasProgress"));
        }

        // Course found in database, add image
        if (!$course->image_url) {
            $colorParts = explode(" ", $course->image_color ?? "from-blue-500 to-blue-600");
            $course->image_url = CourseImageService::generateImageUrl(
                $course->title,
                $course->category,
                $colorParts
            );
        }

        // Get related courses from database
        $relatedCourses = \App\Models\Noccea\Learn\Course::where("category", $course->category)
            ->where("id", "!=", $course->id)
            ->take(3)
            ->get()
            ->map(function ($c) {
                if (!$c->image_url) {
                    $colorParts = explode(" ", $c->image_color ?? "from-blue-500 to-blue-600");
                    $c->image_url = CourseImageService::generateImageUrl(
                        $c->title,
                        $c->category,
                        $colorParts
                    );
                }
                return $c;
            });

        // Check if user is enrolled
        $isEnrolled = false;
        $firstLessonUrl = null;
        $hasProgress = false;

        if (auth()->check()) {
            $isEnrolled = $course->enrollments()
                ->where('user_id', auth()->id())
                ->exists();

            if ($isEnrolled) {
                // Check if user has completed any lessons
                $hasProgress = \App\Models\Noccea\Learn\LessonCompletion::where('user_id', auth()->id())
                    ->whereHas('lesson', function($query) use ($course) {
                        $query->whereHas('module', function($q) use ($course) {
                            $q->where('course_id', $course->id);
                        });
                    })
                    ->exists();

                // Get first lesson URL
                $firstModule = $course->modules()->orderBy('order')->first();
                if ($firstModule) {
                    $firstLesson = $firstModule->lessons()->orderBy('order')->first();
                    if ($firstLesson) {
                        $firstLessonUrl = route('noccea.learn.lesson.show', [
                            'courseSlug' => $course->slug,
                            'moduleName' => \Illuminate\Support\Str::slug($firstModule->title),
                            'lessonId' => $firstLesson->id
                        ]);
                    }
                }
            }
        }

        return view("noccea.learn.courses.show", compact("course", "relatedCourses", "isEnrolled", "firstLessonUrl", "hasProgress"));
    }
    public function instructors()
    {
        $instructors = \App\Models\User::where('is_active', true)
            ->whereNotNull('name')
            ->where('name', '!=', '')
            ->whereRaw("username NOT LIKE '%@%'") // Exclude email-based usernames
            ->take(8)
            ->get()
            ->map(function ($user) {
                $user->rating = rand(4, 5);
                $user->specialty = ['Web Development', 'Data Science', 'Mobile Apps', 'Cloud Computing', 'AI & ML', 'DevOps', 'Design', 'Leadership'][$user->id % 8];
                return $user;
            });

        return view('noccea.learn.instructors.index', ['instructors' => $instructors]);
    }

    public function studyGroups()
    {
        return view('noccea.learn.study-groups.index');
    }

    public function qaForum()
    {
        return view('noccea.learn.qa-forum.index');
    }

    public function leaderboard()
    {
        $topLearners = \App\Models\User::where('is_active', true)
            ->orderByDesc('id')
            ->take(10)
            ->get()
            ->map(function ($user, $index) {
                $user->rank = $index + 1;
                $user->points = 5000 - ($index * 100);
                $user->courses = 10 - ($index % 5);
                $user->certificates = 5 - ($index % 3);
                return $user;
            });

        return view('noccea.learn.leaderboard.index', ['topLearners' => $topLearners]);
    }

    public function bookmarks()
    {
        return view('noccea.learn.bookmarks.index');
    }

    public function certificates()
    {
        $certificates = [];
        if (auth()->check()) {
            $certificates = \App\Models\Noccea\Learn\UserCertificate::with('course')
                ->where('user_id', auth()->id())
                ->latest('issued_at')
                ->get();
        }
        return view('noccea.learn.certificates.index', compact('certificates'));
    }

    public function enroll(\Illuminate\Http\Request $request)
    {
        try {
            $courseId = $request->input('course_id');
            $userId = auth()->id();

            // Check if already enrolled
            $enrolled = \DB::table('course_enrollments')
                ->where('user_id', $userId)
                ->where('course_id', $courseId)
                ->first();

            if ($enrolled) {
                // Get the course and redirect to first lesson
                $course = \App\Models\Noccea\Learn\Course::find($courseId);
                if ($course) {
                    $firstModule = $course->modules()->orderBy('order')->first();
                    if ($firstModule) {
                        $firstLesson = $firstModule->lessons()->orderBy('order')->first();
                        if ($firstLesson) {
                            return redirect()->route('noccea.learn.lessons.show', [
                                'courseSlug' => $course->slug,
                                'moduleName' => \Illuminate\Support\Str::slug($firstModule->title),
                                'lessonId' => $firstLesson->id
                            ])->with('info', 'You are already enrolled in this course');
                        }
                    }
                }
                return redirect()->back()->with('info', 'You are already enrolled in this course');
            }

            // Create enrollment record
            \DB::table('course_enrollments')->insert([
                'user_id' => $userId,
                'course_id' => $courseId,
                'enrolled_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Get the course and redirect to first lesson
            $course = \App\Models\Noccea\Learn\Course::find($courseId);
            if ($course) {
                $firstModule = $course->modules()->orderBy('order')->first();
                if ($firstModule) {
                    $firstLesson = $firstModule->lessons()->orderBy('order')->first();
                    if ($firstLesson) {
                        return redirect()->route('noccea.learn.lessons.show', [
                            'courseSlug' => $course->slug,
                            'moduleName' => \Illuminate\Support\Str::slug($firstModule->title),
                            'lessonId' => $firstLesson->id
                        ])->with('success', 'Successfully enrolled! Let\'s start learning.');
                    }
                }
            }

            return redirect()->back()->with('success', 'Successfully enrolled in the course!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to enroll: ' . $e->getMessage());
        }
    }
}
