<?php

namespace Database\Seeders;

use App\Models\JobListing;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    public function run(): void
    {
        $jobs = [
            [
                'title'            => 'Senior Full-Stack Engineer',
                'location'         => 'New York, NY (Hybrid)',
                'type'             => 'Full-Time',
                'status'           => 'active',
                'description'      => "We're looking for a Senior Full-Stack Engineer to join our core product team. You'll own significant parts of our platform, ship features that reach thousands of daily users, and mentor a growing engineering team.\n\nThis is a high-trust role — you'll have genuine autonomy and direct input into the technical direction of the product.",
                'responsibilities' => "Design and build scalable features across our Laravel/React stack\nParticipate in architecture reviews and technical planning\nMentor mid-level engineers through code reviews and pairing\nMonitor production health and drive reliability improvements\nCollaborate closely with product and design teams",
                'requirements'     => "5+ years of professional full-stack development experience\nDeep expertise in Laravel and a modern JS framework (React preferred)\nStrong grasp of relational databases and query optimisation\nExperience with cloud infrastructure (AWS / GCP)\nExcellent written communication — we're an async-first team",
            ],
            [
                'title'            => 'Product Designer',
                'location'         => 'Remote (Global)',
                'type'             => 'Remote',
                'status'           => 'active',
                'description'      => "We're hiring a Product Designer who obsesses over the details and can move from fuzzy problem space to polished, shipped interface. You'll own design across web and mobile, from discovery to delivery.\n\nExpect a high level of craft, a supportive design review culture, and a team that cares deeply about the work.",
                'responsibilities' => "Lead design for new product features end-to-end\nConduct user research, interviews, and usability testing\nMaintain and extend our Figma design system\nWork closely with engineers to ensure fidelity in implementation\nPresent and defend design decisions to stakeholders",
                'requirements'     => "4+ years of product design experience in SaaS or consumer tech\nStrong Figma skills and an impressive portfolio\nExperience building and maintaining design systems\nComfort with data — you use metrics to guide design decisions\nAsynchronous communication skills; we write before we meet",
            ],
            [
                'title'            => 'Head of Marketing',
                'location'         => 'London, UK',
                'type'             => 'Full-Time',
                'status'           => 'active',
                'description'      => "We're looking for a Head of Marketing to own our go-to-market strategy and build a world-class marketing function from the ground up. You'll report directly to the CEO and work cross-functionally with Sales, Product, and Design.\n\nThis is a builder role — we need someone who can think strategically and still get their hands dirty.",
                'responsibilities' => "Define and execute the overall marketing strategy\nBuild and manage a small, high-output marketing team\nOwn pipeline generation targets in partnership with Sales\nManage budget allocation across channels\nDevelop brand positioning and messaging frameworks",
                'requirements'     => "6+ years of B2B marketing experience, 2+ in a leadership role\nProven track record driving pipeline in a SaaS business\nDeep expertise in at least two of: content, demand-gen, product marketing\nStrong analytical skills — you live in dashboards and know your CAC/LTV\nExceptional written communication",
            ],
        ];

        foreach ($jobs as $job) {
            JobListing::create($job);
        }

        $this->command->info('3 demo jobs seeded.');
    }
}
