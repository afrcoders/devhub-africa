<?php

namespace Database\Seeders;

use App\Models\Africoders\Page;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about',
                'page_type' => 'about',
                'featured_image' => '/images/about.jpg',
                'content' => '<h2>Building Africa\'s Digital Future</h2>

<p>Africoders is more than just a software development studio—we\'re a venture incubator, innovation hub, and strategic partner for companies looking to transform their digital presence. Founded with a mission to drive technological advancement across Africa, we combine deep technical expertise with entrepreneurial vision.</p>

<div class="row my-5">
    <div class="col-md-6">
        <img src="/images/team.jpg" alt="Our Team" class="img-fluid rounded shadow-sm">
    </div>
    <div class="col-md-6">
        <h3>Our Story</h3>
        <p>We began with a simple belief: Africa has immense talent and opportunity, but lacked platforms to showcase and scale that talent globally. Our team of experienced developers, entrepreneurs, and strategists came together to create solutions that address real-world challenges while building sustainable businesses.</p>
        <p>Since our inception, we\'ve incubated multiple ventures, worked with hundreds of clients across the continent, and trained the next generation of African technologists. Every project we undertake is driven by our commitment to quality, innovation, and positive impact.</p>
    </div>
</div>

<div class="row my-5">
    <div class="col-md-6 order-md-2">
        <img src="/images/collaboration.jpg" alt="Collaboration" class="img-fluid rounded shadow-sm">
    </div>
    <div class="col-md-6 order-md-1">
        <h3>Who We Are</h3>
        <p>Our diverse team includes software engineers, product designers, business strategists, and domain experts across healthcare, fintech, education, and enterprise software. We bring together technical excellence with market insights to create solutions that don\'t just work—they thrive.</p>
        <p>We\'re not just developers—we\'re problem-solvers, innovators, and entrepreneurs who understand what it takes to build scalable, sustainable businesses.</p>
    </div>
</div>

<div class="row my-5">
    <div class="col-md-6">
        <img src="/images/strategy.jpg" alt="Our Approach" class="img-fluid rounded shadow-sm">
    </div>
    <div class="col-md-6">
        <h3>Our Approach</h3>
        <p>We follow a collaborative, iterative methodology that puts our clients and users at the center of everything we build. Whether you\'re launching a startup, modernizing legacy systems, or scaling an existing platform, we work as an extension of your team to ensure success.</p>
        <p>Our process is transparent, agile, and results-focused. We communicate constantly, adapt quickly, and deliver consistently.</p>
    </div>
</div>

<h3 class="my-5">Why Choose Africoders</h3>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="p-4 bg-light rounded">
            <h5><i class="bi bi-trophy text-primary"></i> Proven Track Record</h5>
            <p>Multiple successful ventures and client projects across Africa with measurable impact.</p>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="p-4 bg-light rounded">
            <h5><i class="bi bi-layers text-primary"></i> Full-Stack Expertise</h5>
            <p>From strategy to implementation to ongoing support—we handle it all.</p>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="p-4 bg-light rounded">
            <h5><i class="bi bi-globe-africa text-primary"></i> African-First Perspective</h5>
            <p>Deep understanding of local markets, challenges, and opportunities.</p>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="p-4 bg-light rounded">
            <h5><i class="bi bi-lightbulb text-primary"></i> Entrepreneurial Mindset</h5>
            <p>We think like founders, not just service providers.</p>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="p-4 bg-light rounded">
            <h5><i class="bi bi-check-circle text-primary"></i> Quality Commitment</h5>
            <p>High standards in every line of code and every design decision.</p>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="p-4 bg-light rounded">
            <h5><i class="bi bi-rocket text-primary"></i> Innovation First</h5>
            <p>Constantly exploring new technologies and methodologies to stay ahead.</p>
        </div>
    </div>
</div>

<div class="alert alert-primary my-5" role="alert">
    <h4 class="alert-heading">Ready to Transform Your Business?</h4>
    <p>Let\'s build something extraordinary together. Whether you need software development, venture incubation, or strategic consulting, we\'re here to help you succeed.</p>
</div>',
                'meta_description' => 'Learn about Africoders - a venture studio driving innovation across Africa through strategic partnerships and ecosystem development.',
                'meta_keywords' => 'about africoders, venture studio, software development, Africa',
                'published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Our Vision',
                'slug' => 'vision',
                'page_type' => 'vision',
                'featured_image' => '/images/vision.jpg',
                'content' => '<h2>A World Where Africa Leads in Technology Innovation</h2>

<p>We envision a future where Africa is recognized as a global center for technological innovation and entrepreneurship. A future where brilliant African minds don\'t have to leave the continent to build world-class products and companies.</p>

<div class="row my-5 align-items-center">
    <div class="col-md-6">
        <img src="/images/innovation.jpg" alt="Technology Innovation" class="img-fluid rounded shadow-sm">
    </div>
    <div class="col-md-6">
        <h3>Our Vision Statement</h3>
        <div class="alert alert-info">
            <p><strong>"To empower African entrepreneurs and businesses with world-class technology solutions, enabling them to compete globally, create jobs locally, and drive sustainable economic growth."</strong></p>
        </div>
    </div>
</div>

<h3 class="my-4">The Africa We\'re Building</h3>

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="p-4 border-start border-primary border-5 bg-light rounded">
            <p><i class="bi bi-cash-coin text-primary"></i> <strong>African startups</strong> are funded by African capital and talent</p>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="p-4 border-start border-primary border-5 bg-light rounded">
            <p><i class="bi bi-tools text-primary"></i> <strong>Technology</strong> is a tool for solving local challenges and creating opportunities</p>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="p-4 border-start border-primary border-5 bg-light rounded">
            <p><i class="bi bi-building text-primary"></i> <strong>Innovation hubs</strong> in Lagos, Nairobi, Johannesburg are producing billion-dollar companies</p>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="p-4 border-start border-primary border-5 bg-light rounded">
            <p><i class="bi bi-star text-primary"></i> <strong>African developers</strong> are leading Fortune 500 teams or running their own companies</p>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="p-4 border-start border-primary border-5 bg-light rounded">
            <p><i class="bi bi-lightbulb text-primary"></i> <strong>Emerging markets problems</strong> drive innovation that benefits the whole world</p>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="p-4 border-start border-primary border-5 bg-light rounded">
            <p><i class="bi bi-globe text-primary"></i> <strong>Africa</strong> is the destination for global tech talent, not just a source market</p>
        </div>
    </div>
</div>

<div class="row my-5 align-items-center">
    <div class="col-md-6 order-md-2">
        <img src="/images/growth.jpg" alt="Growth and Expansion" class="img-fluid rounded shadow-sm">
    </div>
    <div class="col-md-6 order-md-1">
        <h3>How We\'re Getting There</h3>
        <ul class="list-unstyled">
            <li class="mb-3"><strong>✓ Incubating</strong> high-impact ventures that solve real African problems</li>
            <li class="mb-3"><strong>✓ Building</strong> platforms that connect African talent with global opportunities</li>
            <li class="mb-3"><strong>✓ Creating</strong> pathways for young technologists to gain experience and build wealth</li>
            <li class="mb-3"><strong>✓ Demonstrating</strong> that world-class technology can be built right here, right now</li>
            <li class="mb-3"><strong>✓ Contributing</strong> to an ecosystem where innovation and entrepreneurship thrive</li>
        </ul>
    </div>
</div>

<div class="alert alert-success my-5" role="alert">
    <h4 class="alert-heading">This is Our Vision</h4>
    <p class="mb-0">This is what drives us every day. This is why we get up in the morning. Join us in building Africa\'s technological future.</p>
</div>',
                'meta_description' => 'Africoders vision - empowering African entrepreneurs with world-class technology solutions.',
                'meta_keywords' => 'vision, mission, Africa, technology, innovation, entrepreneurship',
                'published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Our Mission',
                'slug' => 'mission',
                'page_type' => 'mission',
                'featured_image' => '/images/mission.jpg',
                'content' => '<h2>Driving Innovation Through Technology Excellence</h2>

<p>Our mission is to conceive, build, and scale innovative software ventures that solve real problems across Africa while creating lasting value for our stakeholders.</p>

<h3 class="my-4">What We Do</h3>

<div class="row mb-5">
    <div class="col-md-6 mb-4">
        <div class="card h-100 border-0 shadow-sm">
            <img src="/images/strategy.jpg" alt="Venture Incubation" class="card-img-top rounded-top">
            <div class="card-body">
                <h5 class="card-title">Venture Incubation</h5>
                <p class="card-text">We identify market gaps, validate ideas, build MVPs, and launch ventures with dedicated teams. From concept to market, we handle every stage of venture creation.</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card h-100 border-0 shadow-sm">
            <img src="/images/collaboration.jpg" alt="Software Development" class="card-img-top rounded-top">
            <div class="card-body">
                <h5 class="card-title">Software Development Services</h5>
                <p class="card-text">We deliver custom software solutions for businesses looking to digitize, scale, or innovate. Whether it\'s mobile apps, web platforms, or enterprise systems, we bring technical excellence and market insight.</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card h-100 border-0 shadow-sm">
            <img src="/images/innovation.jpg" alt="Technology Consulting" class="card-img-top rounded-top">
            <div class="card-body">
                <h5 class="card-title">Technology Consulting</h5>
                <p class="card-text">We advise organizations on digital transformation, technology strategy, and organizational scaling. Our experience across multiple sectors means we understand your challenges.</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card h-100 border-0 shadow-sm">
            <img src="/images/growth.jpg" alt="Talent Development" class="card-img-top rounded-top">
            <div class="card-body">
                <h5 class="card-title">Talent Development</h5>
                <p class="card-text">We train and mentor the next generation of African technologists through project-based learning and hands-on experience in real ventures.</p>
            </div>
        </div>
    </div>
</div>

<h3 class="my-4">Our Core Values</h3>

<div class="row mb-5">
    <div class="col-md-4 mb-3">
        <div class="p-4 bg-light rounded text-center">
            <h6 class="text-primary mb-2">★ Excellence</h6>
            <p class="small">We don\'t compromise on quality. Every solution reflects our commitment to excellence.</p>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="p-4 bg-light rounded text-center">
            <h6 class="text-primary mb-2">★ Impact</h6>
            <p class="small">We measure success not just by profit, but by positive impact on communities and economies.</p>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="p-4 bg-light rounded text-center">
            <h6 class="text-primary mb-2">★ Innovation</h6>
            <p class="small">We constantly explore new technologies and approaches to solve problems better.</p>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="p-4 bg-light rounded text-center">
            <h6 class="text-primary mb-2">★ Integrity</h6>
            <p class="small">We operate with transparency, honesty, and accountability in all our dealings.</p>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="p-4 bg-light rounded text-center">
            <h6 class="text-primary mb-2">★ Collaboration</h6>
            <p class="small">We believe the best solutions come from diverse teams working together toward shared goals.</p>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="p-4 bg-light rounded text-center">
            <h6 class="text-primary mb-2">★ African Pride</h6>
            <p class="small">We take pride in being African, and we build with Africa\'s future in mind.</p>
        </div>
    </div>
</div>

<h3 class="my-4">How We Measure Success</h3>

<div class="row">
    <div class="col-md-6">
        <ul class="list-unstyled">
            <li class="mb-3"><i class="bi bi-check-circle text-success"></i> <strong>Ventures</strong> that achieve profitability and positive market impact</li>
            <li class="mb-3"><i class="bi bi-check-circle text-success"></i> <strong>Client satisfaction</strong> and long-term partnerships</li>
            <li class="mb-3"><i class="bi bi-check-circle text-success"></i> <strong>Technical excellence</strong> and code quality</li>
        </ul>
    </div>
    <div class="col-md-6">
        <ul class="list-unstyled">
            <li class="mb-3"><i class="bi bi-check-circle text-success"></i> <strong>Team growth</strong> and professional development</li>
            <li class="mb-3"><i class="bi bi-check-circle text-success"></i> <strong>Ecosystem contribution</strong> to Africa\'s tech landscape</li>
            <li class="mb-3"><i class="bi bi-check-circle text-success"></i> <strong>Economic value</strong> created for stakeholders</li>
        </ul>
    </div>
</div>

<div class="alert alert-warning my-5" role="alert">
    <h4 class="alert-heading">This is Our Mission</h4>
    <p class="mb-0">This is how we create change. This is how we build Africa\'s future. Join us in this journey.</p>
</div>',
                'meta_description' => 'Africoders mission - conceiving, building, and scaling innovative software ventures across Africa.',
                'meta_keywords' => 'mission, ventures, software development, Africa, innovation',
                'published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Partnerships',
                'slug' => 'partnerships',
                'page_type' => 'partnerships',
                'featured_image' => '/images/collaboration.jpg',
                'content' => '<h2>Growing Together Through Strategic Partnerships</h2>

<p>At Africoders, we believe in the power of collaboration. Our success is built on strong partnerships with visionary companies, investors, developers, and organizations who share our mission to transform Africa\'s technology landscape.</p>

<div class="row my-5">
    <div class="col-md-6">
        <img src="/images/growth.jpg" alt="Partnership Growth" class="img-fluid rounded shadow-sm">
    </div>
    <div class="col-md-6">
        <h3>Why Partner With Us?</h3>
        <ul class="list-unstyled">
            <li class="mb-3"><i class="bi bi-check-circle text-success"></i> <strong>Proven Track Record:</strong> We\'ve successfully launched and scaled multiple ventures across diverse industries</li>
            <li class="mb-3"><i class="bi bi-check-circle text-success"></i> <strong>Expert Team:</strong> Access to deep technical expertise, market insights, and entrepreneurial experience</li>
            <li class="mb-3"><i class="bi bi-check-circle text-success"></i> <strong>Network Effect:</strong> Connect with other ventures, investors, and strategic partners in our ecosystem</li>
            <li class="mb-3"><i class="bi bi-check-circle text-success"></i> <strong>Market Access:</strong> Leverage our presence across East, West, and Southern Africa</li>
        </ul>
    </div>
</div>

<h3 class="my-4">Partnership Opportunities</h3>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-briefcase text-primary me-2"></i>Technology Partners</h5>
                <p class="card-text">Are you a technology provider, software company, or service provider? Let\'s integrate and create value for mutual customers. From APIs and integrations to co-marketing opportunities, there\'s much we can achieve together.</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-cash-coin text-success me-2"></i>Investment Partners</h5>
                <p class="card-text">Looking to invest in Africa\'s technology ecosystem? We offer equity investment opportunities in our portfolio ventures, with exposure to multiple sectors including fintech, healthtech, edutech, and enterprise software.</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-people text-info me-2"></i>Strategic Partners</h5>
                <p class="card-text">Corporate partners seeking to innovate, expand in Africa, or access African talent. We can help with custom software development, team augmentation, R&amp;D partnerships, and market entry strategies.</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-mortarboard text-warning me-2"></i>Education Partners</h5>
                <p class="card-text">Universities, bootcamps, and training organizations—let\'s build talent pipelines together. We offer internship programs, curriculum development partnerships, and career pathways for emerging developers.</p>
            </div>
        </div>
    </div>
</div>

<h3 class="my-4">Our Partner Network</h3>

<p>We currently work with over 50+ partners across different sectors:</p>

<div class="row my-4">
    <div class="col-md-6">
        <div class="bg-light p-4 rounded mb-4">
            <h6 class="mb-3"><i class="bi bi-arrow-right text-primary me-2"></i><strong>Corporate Partners</strong></h6>
            <p class="mb-0">Enterprise companies across fintech, healthcare, e-commerce, and SaaS sectors who leverage our development expertise and market insights.</p>
        </div>
        <div class="bg-light p-4 rounded mb-4">
            <h6 class="mb-3"><i class="bi bi-arrow-right text-success me-2"></i><strong>Technology Platforms</strong></h6>
            <p class="mb-0">Cloud providers, dev tools, and infrastructure companies integrated with our ventures for seamless operations and best-in-class solutions.</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="bg-light p-4 rounded mb-4">
            <h6 class="mb-3"><i class="bi bi-arrow-right text-info me-2"></i><strong>Investment Firms</strong></h6>
            <p class="mb-0">VCs and institutional investors who back our ventures and believe in the potential of Africa\'s technology ecosystem.</p>
        </div>
        <div class="bg-light p-4 rounded mb-4">
            <h6 class="mb-3"><i class="bi bi-arrow-right text-warning me-2"></i><strong>Communities</strong></h6>
            <p class="mb-0">Developer communities, industry associations, and NGOs working towards digital transformation and economic empowerment.</p>
        </div>
    </div>
</div>

<div class="alert alert-primary my-5" role="alert">
    <h4 class="alert-heading">Ready to Partner?</h4>
    <p class="mb-0">Whether you\'re a technology provider, investor, enterprise client, or organization passionate about Africa\'s tech future, we\'d love to explore collaboration opportunities. <a href="https://\' . config(\'domains.africoders.help\') . \'/contact" class="alert-link">Get in touch with our partnerships team</a> to discuss how we can work together.</p>
</div>',
                'meta_description' => 'Africoders partnerships - collaborate with Africa\'s leading venture studio and innovation hub.',
                'meta_keywords' => 'partnerships, collaboration, strategic partners, investment, Africa, technology',
                'published' => true,
                'published_at' => now(),
            ],
        ];

        foreach ($pages as $page) {
            Page::firstOrCreate(
                ['slug' => $page['slug']],
                $page
            );
        }
    }
}
