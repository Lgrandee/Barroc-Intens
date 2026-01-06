<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds with realistic Dutch business customers.
     */
    public function run(): void
    {
        // Realistic Dutch B2B customers for a coffee machine company
        $customers = [
            // Hotels & Hospitality
            ['name_company' => 'Hotel Okura Amsterdam', 'contact_person' => 'Jan van der Berg', 'email' => 'inkoop@okura-amsterdam.nl', 'phone_number' => '020-6787111', 'bkr_number' => 'BKR-2845621', 'address' => 'Ferdinand Bolstraat 333', 'city' => 'Amsterdam', 'zipcode' => '1072 LH', 'bkr_status' => 'approved'],
            ['name_company' => 'Fletcher Hotels Groep', 'contact_person' => 'Marloes Dekker', 'email' => 'facilitair@fletcher.nl', 'phone_number' => '033-4228800', 'bkr_number' => 'BKR-1923847', 'address' => 'Kleine Koppel 26', 'city' => 'Amersfoort', 'zipcode' => '3812 PH', 'bkr_status' => 'approved'],
            ['name_company' => 'Van der Valk Hotelketen', 'contact_person' => 'Peter Smit', 'email' => 'inkoop@vandervalk.nl', 'phone_number' => '030-2809500', 'bkr_number' => 'BKR-3847562', 'address' => 'Winthontlaan 4', 'city' => 'Utrecht', 'zipcode' => '3526 KV', 'bkr_status' => 'approved'],
            
            // Offices & Corporate
            ['name_company' => 'ING Bank N.V.', 'contact_person' => 'Sandra Willems', 'email' => 'facility.services@ing.nl', 'phone_number' => '020-5639111', 'bkr_number' => 'BKR-9182736', 'address' => 'Bijlmerdreef 106', 'city' => 'Amsterdam', 'zipcode' => '1102 CT', 'bkr_status' => 'approved'],
            ['name_company' => 'Rabobank Utrecht', 'contact_person' => 'Marco de Vries', 'email' => 'inkoop@rabobank.nl', 'phone_number' => '030-2160000', 'bkr_number' => 'BKR-7364829', 'address' => 'Croeselaan 18', 'city' => 'Utrecht', 'zipcode' => '3521 CB', 'bkr_status' => 'approved'],
            ['name_company' => 'KPMG Nederland', 'contact_person' => 'Lisa Bakker', 'email' => 'office.services@kpmg.nl', 'phone_number' => '020-6568888', 'bkr_number' => 'BKR-5647382', 'address' => 'Laan van Langerhuize 1', 'city' => 'Amstelveen', 'zipcode' => '1186 DS', 'bkr_status' => 'approved'],
            ['name_company' => 'Deloitte Nederland', 'contact_person' => 'Thomas Hendriks', 'email' => 'facilities@deloitte.nl', 'phone_number' => '088-2881000', 'bkr_number' => 'BKR-4829173', 'address' => 'Gustav Mahlerlaan 2970', 'city' => 'Amsterdam', 'zipcode' => '1081 LA', 'bkr_status' => 'approved'],
            
            // Restaurants & Cafés
            ['name_company' => 'Bagels & Beans B.V.', 'contact_person' => 'Erik Jansen', 'email' => 'operations@bagelsbeans.nl', 'phone_number' => '020-4204040', 'bkr_number' => 'BKR-2938475', 'address' => 'Overtoom 50', 'city' => 'Amsterdam', 'zipcode' => '1054 HK', 'bkr_status' => 'approved'],
            ['name_company' => 'Lebkov Amsterdam', 'contact_person' => 'Nina Vermeer', 'email' => 'info@lebkov.nl', 'phone_number' => '020-3445566', 'bkr_number' => 'BKR-6758493', 'address' => 'Rokin 75', 'city' => 'Amsterdam', 'zipcode' => '1012 KL', 'bkr_status' => 'approved'],
            ['name_company' => 'Restaurant De Kas', 'contact_person' => 'Gert Blom', 'email' => 'inkoop@restaurantdekas.nl', 'phone_number' => '020-4624562', 'bkr_number' => 'BKR-8374652', 'address' => 'Kamerlingh Onneslaan 3', 'city' => 'Amsterdam', 'zipcode' => '1097 DE', 'bkr_status' => 'approved'],
            
            // Healthcare
            ['name_company' => 'VU Medisch Centrum', 'contact_person' => 'Dr. Hans Mulder', 'email' => 'facilitair@vumc.nl', 'phone_number' => '020-4444444', 'bkr_number' => 'BKR-1029384', 'address' => 'De Boelelaan 1117', 'city' => 'Amsterdam', 'zipcode' => '1081 HV', 'bkr_status' => 'approved'],
            ['name_company' => 'Erasmus MC Rotterdam', 'contact_person' => 'Annemarie Visser', 'email' => 'inkoop@erasmusmc.nl', 'phone_number' => '010-7040704', 'bkr_number' => 'BKR-5647382', 'address' => "Dr. Molewaterplein 40", 'city' => 'Rotterdam', 'zipcode' => '3015 GD', 'bkr_status' => 'approved'],
            ['name_company' => 'UMC Utrecht', 'contact_person' => 'Rob Pietersen', 'email' => 'facility@umcutrecht.nl', 'phone_number' => '088-7555555', 'bkr_number' => 'BKR-9182736', 'address' => 'Heidelberglaan 100', 'city' => 'Utrecht', 'zipcode' => '3584 CX', 'bkr_status' => 'approved'],
            
            // Education
            ['name_company' => 'Universiteit van Amsterdam', 'contact_person' => 'Kees de Jong', 'email' => 'inkoop@uva.nl', 'phone_number' => '020-5259111', 'bkr_number' => 'BKR-3748291', 'address' => 'Spui 21', 'city' => 'Amsterdam', 'zipcode' => '1012 WX', 'bkr_status' => 'approved'],
            ['name_company' => 'TU Delft', 'contact_person' => 'Ingrid van Dijk', 'email' => 'facilitair@tudelft.nl', 'phone_number' => '015-2789111', 'bkr_number' => 'BKR-6758493', 'address' => 'Mekelweg 5', 'city' => 'Delft', 'zipcode' => '2628 CD', 'bkr_status' => 'approved'],
            ['name_company' => 'Hogeschool Rotterdam', 'contact_person' => 'Willem Bos', 'email' => 'services@hr.nl', 'phone_number' => '010-7948200', 'bkr_number' => 'BKR-2938475', 'address' => 'Museumpark 40', 'city' => 'Rotterdam', 'zipcode' => '3015 CX', 'bkr_status' => 'approved'],
            
            // Retail & Co-working
            ['name_company' => 'WeWork Netherlands', 'contact_person' => 'Sophie van Leeuwen', 'email' => 'operations@wework.nl', 'phone_number' => '020-8006600', 'bkr_number' => 'BKR-4829173', 'address' => 'Weteringschans 165', 'city' => 'Amsterdam', 'zipcode' => '1017 XD', 'bkr_status' => 'approved'],
            ['name_company' => 'Spaces Amsterdam', 'contact_person' => 'Mark Kuijpers', 'email' => 'amsterdam@spacesworks.com', 'phone_number' => '020-5210000', 'bkr_number' => 'BKR-8374652', 'address' => 'Herengracht 124', 'city' => 'Amsterdam', 'zipcode' => '1015 BT', 'bkr_status' => 'approved'],
            ['name_company' => 'The Student Hotel Rotterdam', 'contact_person' => 'Eva Mol', 'email' => 'inkoop@thestudenthotel.com', 'phone_number' => '010-2060700', 'bkr_number' => 'BKR-1029384', 'address' => 'Wijnhaven 107', 'city' => 'Rotterdam', 'zipcode' => '3011 WN', 'bkr_status' => 'approved'],
            
            // Manufacturing & Logistics
            ['name_company' => 'Philips Nederland', 'contact_person' => 'Bas Verhoeven', 'email' => 'facility@philips.com', 'phone_number' => '040-2792000', 'bkr_number' => 'BKR-7364829', 'address' => 'High Tech Campus 5', 'city' => 'Eindhoven', 'zipcode' => '5656 AE', 'bkr_status' => 'approved'],
            ['name_company' => 'ASML Veldhoven', 'contact_person' => 'Petra Claessens', 'email' => 'services@asml.com', 'phone_number' => '040-2689111', 'bkr_number' => 'BKR-5647382', 'address' => 'De Run 6501', 'city' => 'Veldhoven', 'zipcode' => '5504 DR', 'bkr_status' => 'approved'],
            ['name_company' => 'Port of Rotterdam', 'contact_person' => 'Joris de Bruijn', 'email' => 'inkoop@portofrotterdam.com', 'phone_number' => '010-2521010', 'bkr_number' => 'BKR-9182736', 'address' => 'Wilhelminakade 909', 'city' => 'Rotterdam', 'zipcode' => '3072 AP', 'bkr_status' => 'approved'],
            
            // Small/Medium Businesses (some with issues)
            ['name_company' => 'Café het Hoekje', 'contact_person' => 'Piet Janssen', 'email' => 'info@hethoekje.nl', 'phone_number' => '020-6234567', 'bkr_number' => 'BKR-1234567', 'address' => 'Damstraat 12', 'city' => 'Amsterdam', 'zipcode' => '1012 JM', 'bkr_status' => 'pending'],
            ['name_company' => 'Bakkerij van Dalen', 'contact_person' => 'Marie van Dalen', 'email' => 'info@bakkerijvandalen.nl', 'phone_number' => '030-2345678', 'bkr_number' => 'BKR-2345678', 'address' => 'Oudegracht 45', 'city' => 'Utrecht', 'zipcode' => '3511 AH', 'bkr_status' => 'approved'],
            ['name_company' => 'Runte Group B.V.', 'contact_person' => 'Ronald Runte', 'email' => 'info@runtegroup.nl', 'phone_number' => '010-4567890', 'bkr_number' => 'BKR-3456789', 'address' => 'Coolsingel 100', 'city' => 'Rotterdam', 'zipcode' => '3011 AG', 'bkr_status' => 'denied'],
            ['name_company' => 'Lunchroom De Smaak', 'contact_person' => 'Anna Huisman', 'email' => 'anna@desmaak.nl', 'phone_number' => '015-2134567', 'bkr_number' => 'BKR-4567890', 'address' => 'Markt 8', 'city' => 'Delft', 'zipcode' => '2611 GS', 'bkr_status' => 'approved'],
            ['name_company' => 'Stichting Buurthuis Noord', 'contact_person' => 'Gerard Vos', 'email' => 'contact@buurthuisnoord.nl', 'phone_number' => '020-6345678', 'bkr_number' => 'BKR-5678901', 'address' => 'Buikslotermeerplein 400', 'city' => 'Amsterdam', 'zipcode' => '1025 WB', 'bkr_status' => 'unknown'],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
