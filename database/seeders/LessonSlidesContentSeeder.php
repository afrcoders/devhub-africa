<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Noccea\Learn\Course;
use App\Models\Noccea\Learn\CourseModule;
use App\Models\Noccea\Learn\CourseLesson;

class LessonSlidesContentSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Generating slide content for all lessons...');

        $courses = Course::with('modules.lessons')->get();

        foreach ($courses as $course) {
            $this->command->info("Processing: {$course->title}");

            foreach ($course->modules as $module) {
                foreach ($module->lessons as $lesson) {
                    $slideContent = $this->generateSlideContent($course, $module, $lesson);

                    $lesson->update([
                        'content' => $slideContent,
                        'video_url' => null, // Remove video URLs
                    ]);

                    $this->command->comment("  ✓ {$lesson->title}");
                }
            }
        }

        $this->command->info('Slide content generated successfully!');
    }

    private function generateSlideContent($course, $module, $lesson)
    {
        $lessonNumber = $this->extractLessonNumber($lesson->title);
        $moduleNumber = $this->extractModuleNumber($module->title);

        // Generate contextual slide content based on course, module, and lesson
        $slides = $this->getSlidesByContext($course->category, $course->level, $moduleNumber, $lessonNumber, $lesson->title);

        return $this->formatSlidesAsHTML($slides);
    }

    private function extractLessonNumber($title)
    {
        preg_match('/Lesson\s+(\d+)/i', $title, $matches);
        return $matches[1] ?? 1;
    }

    private function extractModuleNumber($title)
    {
        preg_match('/Module\s+(\d+)/i', $title, $matches);
        return $matches[1] ?? 1;
    }

    private function getSlidesByContext($category, $level, $moduleNum, $lessonNum, $lessonTitle)
    {
        // Default slide structure
        $slides = [];

        if ($moduleNum == 1) {
            $slides = $this->getIntroductionSlides($lessonNum, $lessonTitle, $category);
        } elseif ($moduleNum == 2) {
            $slides = $this->getCoreConceptSlides($lessonNum, $lessonTitle, $category);
        } elseif ($moduleNum == 3) {
            $slides = $this->getAdvancedTopicsSlides($lessonNum, $lessonTitle, $category);
        } else {
            $slides = $this->getGenericSlides($lessonNum, $lessonTitle, $category);
        }

        return $slides;
    }

    private function getIntroductionSlides($lessonNum, $title, $category)
    {
        return [
            [
                'title' => $title,
                'content' => "Welcome to this lesson! Let's explore the fundamentals and build a strong foundation.",
                'type' => 'intro'
            ],
            [
                'title' => 'Learning Objectives',
                'bullets' => [
                    'Understand core concepts',
                    'Apply practical techniques',
                    'Build hands-on projects',
                    'Master best practices'
                ],
                'type' => 'objectives'
            ],
            [
                'title' => 'Key Concepts',
                'content' => 'We will cover essential topics that form the building blocks of ' . $category . '.',
                'bullets' => [
                    'Fundamental principles',
                    'Industry standards',
                    'Real-world applications',
                    'Common patterns'
                ],
                'type' => 'content'
            ],
            [
                'title' => 'Practical Examples',
                'content' => 'Let\'s see how these concepts apply in real-world scenarios.',
                'code' => $this->getExampleCode($category, $lessonNum),
                'type' => 'code'
            ],
            [
                'title' => 'Best Practices',
                'bullets' => [
                    'Write clean, maintainable code',
                    'Follow industry conventions',
                    'Test your implementations',
                    'Document your work'
                ],
                'type' => 'tips'
            ],
            [
                'title' => 'Summary & Next Steps',
                'content' => 'Great work! You\'ve completed this lesson.',
                'bullets' => [
                    'Review key concepts',
                    'Complete practice exercises',
                    'Move to the next lesson',
                    'Apply what you\'ve learned'
                ],
                'type' => 'summary'
            ]
        ];
    }

    private function getCoreConceptSlides($lessonNum, $title, $category)
    {
        return [
            [
                'title' => $title,
                'content' => "Deep dive into core concepts that power modern " . $category . ".",
                'type' => 'intro'
            ],
            [
                'title' => 'What You\'ll Learn',
                'bullets' => [
                    'Advanced techniques',
                    'Performance optimization',
                    'Scalable architectures',
                    'Production-ready patterns'
                ],
                'type' => 'objectives'
            ],
            [
                'title' => 'Technical Deep Dive',
                'content' => 'Understanding the underlying mechanics and architecture.',
                'bullets' => [
                    'System design principles',
                    'Data flow patterns',
                    'State management',
                    'Error handling strategies'
                ],
                'type' => 'content'
            ],
            [
                'title' => 'Code Implementation',
                'content' => 'Let\'s implement these concepts with practical code examples.',
                'code' => $this->getAdvancedCode($category, $lessonNum),
                'type' => 'code'
            ],
            [
                'title' => 'Common Pitfalls',
                'bullets' => [
                    'Avoid anti-patterns',
                    'Performance bottlenecks',
                    'Security considerations',
                    'Debugging techniques'
                ],
                'type' => 'warning'
            ],
            [
                'title' => 'Wrap Up',
                'content' => 'You now have a solid understanding of these core concepts.',
                'bullets' => [
                    'Practice with exercises',
                    'Build a project',
                    'Explore advanced topics',
                    'Share your learnings'
                ],
                'type' => 'summary'
            ]
        ];
    }

    private function getAdvancedTopicsSlides($lessonNum, $title, $category)
    {
        return [
            [
                'title' => $title,
                'content' => "Master advanced techniques and professional workflows in " . $category . ".",
                'type' => 'intro'
            ],
            [
                'title' => 'Advanced Objectives',
                'bullets' => [
                    'Expert-level patterns',
                    'Enterprise solutions',
                    'Optimization strategies',
                    'Industry best practices'
                ],
                'type' => 'objectives'
            ],
            [
                'title' => 'Professional Techniques',
                'content' => 'Learn how professionals approach complex problems.',
                'bullets' => [
                    'Scalable architecture',
                    'Performance tuning',
                    'Security hardening',
                    'Continuous improvement'
                ],
                'type' => 'content'
            ],
            [
                'title' => 'Advanced Implementation',
                'content' => 'Professional-grade code examples and patterns.',
                'code' => $this->getExpertCode($category, $lessonNum),
                'type' => 'code'
            ],
            [
                'title' => 'Real-World Projects',
                'content' => 'Apply your knowledge to production-level projects.',
                'bullets' => [
                    'Build scalable applications',
                    'Deploy to production',
                    'Monitor and optimize',
                    'Maintain and iterate'
                ],
                'type' => 'project'
            ],
            [
                'title' => 'Course Completion',
                'content' => 'Congratulations! You\'ve mastered advanced concepts.',
                'bullets' => [
                    'Continue learning',
                    'Build your portfolio',
                    'Join the community',
                    'Share your knowledge'
                ],
                'type' => 'summary'
            ]
        ];
    }

    private function getGenericSlides($lessonNum, $title, $category)
    {
        return [
            [
                'title' => $title,
                'content' => "Explore important concepts in " . $category . ".",
                'type' => 'intro'
            ],
            [
                'title' => 'What We\'ll Cover',
                'bullets' => [
                    'Key concepts and principles',
                    'Practical applications',
                    'Code examples',
                    'Best practices'
                ],
                'type' => 'objectives'
            ],
            [
                'title' => 'Main Content',
                'content' => 'Let\'s dive into the details.',
                'bullets' => [
                    'Fundamental concepts',
                    'Step-by-step approach',
                    'Practical examples',
                    'Tips and tricks'
                ],
                'type' => 'content'
            ],
            [
                'title' => 'Code Example',
                'content' => 'Here\'s how to implement this in practice.',
                'code' => $this->getExampleCode($category, $lessonNum),
                'type' => 'code'
            ],
            [
                'title' => 'Key Takeaways',
                'bullets' => [
                    'Remember the core concepts',
                    'Practice regularly',
                    'Experiment with code',
                    'Build projects'
                ],
                'type' => 'tips'
            ],
            [
                'title' => 'Next Steps',
                'content' => 'Continue your learning journey!',
                'bullets' => [
                    'Review this lesson',
                    'Try the exercises',
                    'Move to next lesson',
                    'Keep practicing'
                ],
                'type' => 'summary'
            ]
        ];
    }

    private function getExampleCode($category, $lessonNum)
    {
        $codeExamples = [
            'Web Development' => "// Example: React Component\nfunction Welcome({ name }) {\n  return (\n    <div className=\"welcome\">\n      <h1>Hello, {name}!</h1>\n      <p>Welcome to our application</p>\n    </div>\n  );\n}\n\nexport default Welcome;",
            'Data Science' => "# Example: Data Analysis\nimport pandas as pd\nimport numpy as np\n\n# Load and analyze data\ndf = pd.read_csv('data.csv')\nprint(df.describe())\n\n# Visualization\ndf.plot(kind='bar')",
            'Mobile Apps' => "// Example: React Native Component\nimport React from 'react';\nimport { View, Text, StyleSheet } from 'react-native';\n\nconst App = () => (\n  <View style={styles.container}>\n    <Text style={styles.title}>Hello Mobile!</Text>\n  </View>\n);\n\nconst styles = StyleSheet.create({\n  container: { flex: 1, justifyContent: 'center' },\n  title: { fontSize: 24, fontWeight: 'bold' }\n});",
            'default' => "// Example Code\nfunction example() {\n  console.log('Learning in action!');\n  \n  // Your code here\n  const result = processData();\n  return result;\n}\n\nexample();"
        ];

        return $codeExamples[$category] ?? $codeExamples['default'];
    }

    private function getAdvancedCode($category, $lessonNum)
    {
        return "// Advanced Implementation\nclass AdvancedExample {\n  constructor() {\n    this.data = [];\n    this.initialize();\n  }\n\n  initialize() {\n    // Setup logic\n    this.loadData();\n    this.configureSettings();\n  }\n\n  async loadData() {\n    try {\n      const response = await fetch('/api/data');\n      this.data = await response.json();\n    } catch (error) {\n      console.error('Error:', error);\n    }\n  }\n\n  process() {\n    return this.data.map(item => ({\n      ...item,\n      processed: true\n    }));\n  }\n}\n\nexport default AdvancedExample;";
    }

    private function getExpertCode($category, $lessonNum)
    {
        return "// Production-Ready Architecture\nimport { createStore, applyMiddleware } from 'redux';\nimport { Provider } from 'react-redux';\nimport thunk from 'redux-thunk';\n\n// Store Configuration\nconst store = createStore(\n  rootReducer,\n  applyMiddleware(thunk)\n);\n\n// Component with Advanced Patterns\nclass EnterpriseComponent extends React.Component {\n  componentDidMount() {\n    this.loadCriticalData();\n    this.setupWebSocket();\n  }\n\n  async loadCriticalData() {\n    const data = await api.fetchWithRetry();\n    this.setState({ data });\n  }\n\n  render() {\n    return (\n      <Provider store={store}>\n        <App />\n      </Provider>\n    );\n  }\n}";
    }

    private function formatSlidesAsHTML($slides)
    {
        $html = '<div class="slides-container">';

        foreach ($slides as $index => $slide) {
            $slideNum = $index + 1;
            $html .= '<div class="slide" data-slide="' . $slideNum . '">';

            // Slide header
            $html .= '<div class="slide-header">';
            $html .= '<h2 class="slide-title">' . htmlspecialchars($slide['title']) . '</h2>';
            $html .= '<span class="slide-number">Slide ' . $slideNum . ' of ' . count($slides) . '</span>';
            $html .= '</div>';

            // Slide content
            $html .= '<div class="slide-content">';

            if (isset($slide['content'])) {
                $html .= '<p class="slide-text">' . htmlspecialchars($slide['content']) . '</p>';
            }

            if (isset($slide['bullets'])) {
                $html .= '<ul class="slide-bullets">';
                foreach ($slide['bullets'] as $bullet) {
                    $html .= '<li>' . htmlspecialchars($bullet) . '</li>';
                }
                $html .= '</ul>';
            }

            if (isset($slide['code'])) {
                $html .= '<pre class="slide-code"><code>' . htmlspecialchars($slide['code']) . '</code></pre>';
            }

            $html .= '</div>'; // slide-content
            $html .= '</div>'; // slide
        }

        $html .= '</div>'; // slides-container

        return $html;
    }
}
