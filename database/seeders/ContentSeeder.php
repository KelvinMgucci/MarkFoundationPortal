<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\Stat;

class ContentSeeder extends Seeder {
    public function run(): void {
        // Stats
        $stats = [
            ['label'=>'Families Supported','value'=>150,'suffix'=>'+','icon'=>'🏠','sort_order'=>1],
            ['label'=>'Students Reached','value'=>500,'suffix'=>'+','icon'=>'📚','sort_order'=>2],
            ['label'=>'Health-Insured Families','value'=>50,'suffix'=>'+','icon'=>'🏥','sort_order'=>3],
            ['label'=>'Women Empowered','value'=>40,'suffix'=>'+','icon'=>'👩‍👧','sort_order'=>4],
            ['label'=>'PWDs Supported','value'=>10,'suffix'=>'+','icon'=>'♿','sort_order'=>5],
        ];
        foreach ($stats as $s) Stat::create($s);

        // Team
        TeamMember::create(['name'=>'Secilia Eliangiringa Mtei','role'=>'Founder & CEO','bio'=>'A visionary educator, entrepreneur, and school founder with over a decade of experience in education, business leadership, and institutional development. Holds a Master\'s in Education; founder of Moriah Pre & Primary School and Moriah College of Professionalism.','email'=>'michellemtei@gmail.com','phone'=>'+255 787 242 434','sort_order'=>1]);
        TeamMember::create(['name'=>'Isack Timotheo','role'=>'Founder & CEO','bio'=>'A trained psychologist and humanitarian leader with years of experience in psychosocial support, community outreach, and education-based interventions.','sort_order'=>2]);

        // Testimonials
        Testimonial::create(['quote'=>'Mark Foundation paid our health insurance when my child was sick. Today, we are safe and hopeful.','author_name'=>'Aisha','author_location'=>"Hanang'",'sort_order'=>1]);
        Testimonial::create(['quote'=>'The career guidance session changed my view on life. I now believe I can succeed and make a difference.','author_name'=>'Student','author_location'=>'Babati Secondary School','sort_order'=>2]);

        // FAQs
        $faqs = [
            ['question'=>'How can I support Mark Foundation?','answer'=>'You can donate, volunteer, or partner with us through the Get Involved section. Every contribution helps us reach more families across Tanzania.','sort_order'=>1],
            ['question'=>"Where does Mark Foundation operate?",'answer'=>"Our headquarters is in Hanang', Manyara, but we reach communities across Tanzania.",'sort_order'=>2],
            ['question'=>'Is my donation tax deductible?','answer'=>'Yes. We are a registered NGO and can provide official receipts for all donations.','sort_order'=>3],
            ['question'=>'How can I volunteer?','answer'=>'We welcome volunteers from all backgrounds. Reach out via email at markfoundation87@gmail.com and our team will be in touch.','sort_order'=>4],
            ['question'=>'Do you collaborate with other organisations?','answer'=>'Yes. We work with schools, hospitals, local government, and other NGOs to amplify impact.','sort_order'=>5],
        ];
        foreach ($faqs as $f) Faq::create($f);

        $this->command->info('Content seeded successfully.');
    }
}
