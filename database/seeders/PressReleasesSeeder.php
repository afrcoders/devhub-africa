<?php

namespace Database\Seeders;

use App\Models\Africoders\PressRelease;
use Illuminate\Database\Seeder;

class PressReleasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $releases = [
            [
                'title' => 'Africoders Launches Revolutionary Venture Studio Platform',
                'slug' => 'africoders-launches-venture-studio-platform',
                'excerpt' => 'Africoders unveils its comprehensive venture studio platform, combining software development excellence with entrepreneurial expertise to incubate and scale African tech ventures.',
                'featured_image' => '/images/press1.jpg',
                'content' => '<h2>Africoders Launches Revolutionary Venture Studio Platform</h2>

<p><strong>Nairobi, Kenya</strong> – Africoders is thrilled to announce the official launch of its integrated venture studio platform, marking a significant milestone in its mission to drive technological innovation across Africa.</p>

<p>The platform brings together a comprehensive suite of tools and services designed to help entrepreneurs, startups, and established businesses build, scale, and manage technology-driven ventures. From initial concept validation to market launch and growth, the platform provides resources, expertise, and funding opportunities.</p>

<h3>Key Features of the Platform</h3>

<ul>
<li><strong>Venture Incubation:</strong> End-to-end support for launching new technology ventures</li>
<li><strong>Technical Excellence:</strong> Access to experienced developers and architects for custom solutions</li>
<li><strong>Market Validation:</strong> Tools and methodologies for testing ideas before full investment</li>
<li><strong>Investor Network:</strong> Connection to venture capitalists and strategic investors</li>
<li><strong>Talent Pipeline:</strong> Access to vetted African tech professionals</li>
<li><strong>Advisory Services:</strong> Strategic guidance from industry experts and successful founders</li>
</ul>

<p>"This platform represents years of experience working with startups and enterprises across Africa," said the Africoders Leadership Team. "We\'ve seen the potential, the challenges, and the opportunities. Now we\'re creating a structured way to transform ideas into sustainable, impactful ventures."</p>

<h3>Impact and Vision</h3>

<p>The launch comes at a critical time for African technology entrepreneurship, with the continent seeing unprecedented investment and talent influx. Africoders\' platform is positioned to accelerate this momentum by removing barriers to entry and providing comprehensive support for venture builders.</p>

<h3>Availability</h3>

<p>The platform is now available to entrepreneurs, investors, and organizations across Africa. Early adopters will benefit from special rates and personalized onboarding support.</p>

<p>For more information, visit www.africoders.com or contact partners@africoders.com</p>',
                'author' => 'Africoders Team',
                'press_category' => 'announcement',
                'featured' => true,
                'published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Noccea Reaches 5,000 Community Members',
                'slug' => 'noccea-reaches-5k-members',
                'excerpt' => 'Noccea, the community platform for African tech professionals, celebrates reaching 5,000 members, driving collaboration and innovation across the continent.',
                'featured_image' => '/images/press2.jpg',
                'content' => '<h2>Noccea Reaches 5,000 Community Members</h2>

<p><strong>Lagos, Nigeria</strong> – Noccea, Africoders\' flagship community platform connecting African tech professionals, entrepreneurs, and innovators, has reached a major milestone with 5,000 members.</p>

<p>This achievement reflects the platform\'s success in creating a vibrant ecosystem where African technologists can share knowledge, collaborate on projects, and access opportunities that drive career and business growth.</p>

<h3>Community Highlights</h3>

<ul>
<li><strong>500+ Discussions:</strong> Active conversations spanning software development, entrepreneurship, and industry trends</li>
<li><strong>1000+ Mentorships:</strong> Connections between experienced professionals and emerging talent</li>
<li><strong>50+ Partnerships:</strong> Companies using Noccea to recruit, engage, and collaborate</li>
<li><strong>100+ Job Placements:</strong> Members who found employment through the platform</li>
</ul>

<p>"Noccea has become the go-to community for African tech talent," shared the Noccea team. "We\'re proud to provide a platform where brilliant minds can connect, learn, and grow together. This milestone is just the beginning."</p>

<h3>What\'s Next</h3>

<p>The team is rolling out new features including dedicated learning paths, skill-based matching for collaboration, and enterprise solutions for organizations looking to build internal communities.</p>

<p>Join the movement at noccea.com</p>',
                'author' => 'Noccea Team',
                'press_category' => 'milestone',
                'featured' => true,
                'published' => true,
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Africoders Launches Comprehensive Learning Platform Across Africa',
                'slug' => 'africoders-learning-platform-launch',
                'excerpt' => 'Africoders unveils its expanded learning platform featuring courses in web development, mobile apps, AI, and data science, empowering African developers with world-class education.',
                'featured_image' => '/images/press3.jpg',
                'content' => '<h2>Africoders Launches Comprehensive Learning Platform Across Africa</h2>

<p><strong>Lagos, Nigeria</strong> – Africoders has officially launched its comprehensive learning platform, offering world-class courses in programming, web development, mobile apps, artificial intelligence, and data science to developers across Africa.</p>

<p>The platform features over 20 structured courses with hands-on projects, real-world applications, and certification programs. With interactive lessons, Q&A forums, and community support, Africoders is democratizing access to quality tech education for African developers.</p>

<h3>Platform Features</h3>

<ul>
<li>20+ comprehensive courses covering modern tech stacks (MERN, Django, Flutter, Machine Learning)</li>
<li>Interactive coding challenges and real-world projects</li>
<li>Active Q&A community with expert instructors and peer support</li>
<li>Industry-recognized certifications upon course completion</li>
</ul>

<p>"This partnership validates our approach to solving real African problems with technology," said the Africoders Leadership Team. "We\'re excited to bring world-class fintech solutions to millions of Africans who deserve better financial services."</p>

<h3>Broader Impact</h3>

<p>The initiative is expected to create 100+ technology jobs and support 20+ fintech startups in the incubation pipeline. It represents a model for how large institutions can partner with innovative tech companies to drive digital transformation.</p>

<p>The solutions will launch in Q2 2024.</p>',
                'author' => 'Africoders Team',
                'press_category' => 'partnership',
                'featured' => false,
                'published' => true,
                'published_at' => now()->subDays(20),
            ],
            [
                'title' => 'Kortextools Launches Free Educational Edition for Students',
                'slug' => 'kortextools-education-launch',
                'excerpt' => 'Kortextools, the all-in-one online tools platform, launches a free educational edition to support students and educators in African schools and universities.',
                'featured_image' => '/images/press4.jpg',
                'content' => '<h2>Kortextools Launches Free Educational Edition for Students</h2>

<p><strong>Accra, Ghana</strong> – Kortextools has announced the launch of its Educational Edition, providing free access to all premium tools for students and educators at African institutions.</p>

<p>This initiative aims to bridge the digital divide and provide educational access to the tools that professionals use daily. Students can now learn with the same software used in professional environments.</p>

<h3>What\'s Included</h3>

<ul>
<li>PDF editing and annotation tools</li>
<li>File conversion and compression services</li>
<li>Document management and collaboration features</li>
<li>Priority support for educational users</li>
<li>Bulk licenses for institutions</li>
</ul>

<p>"Education is the foundation of innovation," said the Kortextools Team. "We\'re removing financial barriers so every student in Africa can access the tools they need to succeed."</p>

<h3>Impact Metrics</h3>

<p>In the pilot phase, Kortextools expects to provide free access to 10,000+ students and train 500+ educators on platform usage.</p>

<p>Register your institution at kortextools.com/education</p>',
                'author' => 'Kortextools Team',
                'press_category' => 'announcement',
                'featured' => true,
                'published' => true,
                'published_at' => now()->subDays(15),
            ],
            [
                'title' => 'Afrihealthsys Awarded for Healthcare Innovation Excellence',
                'slug' => 'afrihealthsys-innovation-award',
                'excerpt' => 'Afrihealthsys receives prestigious award for excellence in healthcare technology innovation and implementation across African healthcare facilities.',
                'featured_image' => '/images/press5.jpg',
                'content' => '<h2>Afrihealthsys Awarded for Healthcare Innovation Excellence</h2>

<p><strong>Cairo, Egypt</strong> – Afrihealthsys has been recognized with the African Healthcare Innovation Award for its groundbreaking hospital management system and commitment to modernizing healthcare delivery across the continent.</p>

<p>The award acknowledges the platform\'s impact on improving patient care, operational efficiency, and healthcare worker productivity across 50+ partner hospitals.</p>

<h3>Award Recognition</h3>

<p>Afrihealthsys was selected from 100+ nominees for:</p>

<ul>
<li><strong>Innovation:</strong> Cutting-edge technology solutions addressing African healthcare challenges</li>
<li><strong>Impact:</strong> Measurable improvements in patient outcomes and operational metrics</li>
<li><strong>Accessibility:</strong> Affordable solutions that work in resource-constrained environments</li>
<li><strong>Scalability:</strong> Platform proven to work across different healthcare settings</li>
</ul>

<p>"This award belongs to the healthcare workers and patients who benefit from our platform every day," said the Afrihealthsys Team. "We\'re committed to continuing this innovation in service of better healthcare for all Africans."</p>

<h3>Results to Date</h3>

<ul>
<li>50,000+ patient records managed daily</li>
<li>30% improvement in appointment accuracy</li>
<li>25% reduction in administrative workload</li>
<li>99.9% system uptime</li>
</ul>

<p>Learn more at afrihealthsys.com</p>',
                'author' => 'Afrihealthsys Team',
                'press_category' => 'award',
                'featured' => false,
                'published' => true,
                'published_at' => now()->subDays(25),
            ],
        ];

        foreach ($releases as $release) {
            PressRelease::firstOrCreate(
                ['slug' => $release['slug']],
                $release
            );
        }
    }
}
