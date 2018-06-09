<?php

namespace backend\models;

use Yii;

//use common\models\PilotInhouseUser;

/**
 * This is the model class for table "company".
 *
 * @property integer $id
 * @property string $company_name
 * @property string $company_address
 * @property string $image
 * @property string $additional_info
 * @property string $full_name
 * @property string $email_address_1
 * @property string $email_address_2
 * @property string $phone
 * @property string $fax
 * @property string $manager
 * @property string $start_date
 * @property string $end_date
 * @property integer $status
 * @property string $remarks
 * @property integer $user_id
 * @property string $created
 * @property string $updated
 */
class Company extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public $googlecap;

    public static function tableName() {
        return 'pilot_company';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            //  ['image', 'image','extensions' => 'jpg, gif, png', 'minSize' => 150 * 150],
            [['company_name'], 'required'],
            [['company_name'], 'unique', 'message' => 'Company name is already taken.'],
            [['company_name'], 'match', 'pattern' => '/^[a-zA-Z0-9 \s]+$/'],
            // [['googlecap'], 'required'],
            [['status'], 'required'],
            [['email_address_1', 'email_address_2'], 'email', 'message' => 'please enter a valid email address'],
            [['status', 'user_id'], 'integer'],
            [['company_name', 'company_address', 'image', 'additional_info', 'full_name', 'email_address_1', 'email_address_2', 'secondary_contact', 'start_date', 'end_date', 'remarks', 'created', 'updated'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'company_name' => 'Company Name',
            'company_address' => 'Company Address',
            'image' => 'Image',
            'additional_info' => 'Additional Info',
            'full_name' => 'Full Name',
            'email_address_1' => 'Email Address 1',
            'email_address_2' => 'Email Address 2',
            'phone' => 'Phone',
            'secondary_contact' => 'secondary_contact',
            'manager' => 'Manager',
            'appreciator' => 'Appreciator',
            'agreement_file' => 'agreement_file',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'status' => 'Status',
            'remarks' => 'Remarks',
            'user_id' => 'User ID',
            'created' => 'Created',
            'updated' => 'Updated',
            'core_values' => 'core_values',
            'country' => 'Country',
            'timezone' => 'Timezone',
            'challenge_name' => 'challenge_name',
        ];
    }

    /*
     * get the imagename from company model
     * for gridview listing page
     * @params $id integer
     * @return mixed
     */

    public static function getImageName($id) {

        $models = Company::find()->where(['id' => $id])->one();
        if (!empty($models->image)) {
            return $models->image;
        } else {
            return "trans.gif.jpg";
        }
    }

    /*
     * get the username and updated date from company model
     * for gridview listing page
     * @params $id integer
     * @params $uid integer
     * @return mixed
     */

    public static function getUpdated($id, $uid) {
        $models = Company::find()->where(['id' => $id])->one();
        $user = PilotInhouseUser::find()->where(['id' => $uid])->one();
        $updated = $models->updated;
        return 'by ' . ucfirst($user->firstname) . ' ' . ucfirst($user->lastname) . '<br>' . date("M d, Y", $updated);
    }

    /*
     * get the full name and phone number from company model
     * for gridview listing page
     * @params $id integer
     * @return mixed
     */

    public static function getContact($id) {
        $models = Company::find()->where(['id' => $id])->one();
        if (!empty($models->phone)) {
            return $models->full_name . '<br>' . $models->phone;
        } else {
            return false;
        }
    }

    /*
     * get the status from company model
     * for gridview listing page
     * @params $id integer
     * @return mixed
     */

    public static function getStatus($id) {
        $models = Company::find()->where(['id' => $id])->one();
        if ($models->status == '1') {
            $status = 'Active';
        } else {
            $status = 'In-Active';
        }
        return $status;
    }

    public static function timezoneCountries() {
        $countries = array(
            'AF' => 'Afghanistan',
            'AL' => 'Albania',
            'DZ' => 'Algeria',
            'AS' => 'American Samoa',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AQ' => 'Antarctica',
            'AG' => 'Antigua And Barbuda',
            'AR' => 'Argentina',
            'AM' => 'Armenia',
            'AW' => 'Aruba',
            'AU' => 'Australia',
            'AT' => 'Austria',
            'AZ' => 'Azerbaijan',
            'BS' => 'Bahamas',
            'BH' => 'Bahrain',
            'BD' => 'Bangladesh',
            'BB' => 'Barbados',
            'BY' => 'Belarus',
            'BE' => 'Belgium',
            'BZ' => 'Belize',
            'BJ' => 'Benin',
            'BM' => 'Bermuda',
            'BT' => 'Bhutan',
            'BO' => 'Bolivia',
            'BA' => 'Bosnia And Herzegovina',
            'BW' => 'Botswana',
            'BV' => 'Bouvet Island',
            'BR' => 'Brazil',
            'IO' => 'British Indian Ocean Territory',
            'BN' => 'Brunei Darussalam',
            'BG' => 'Bulgaria',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'KH' => 'Cambodia',
            'CM' => 'Cameroon',
            'CA' => 'Canada',
            'CV' => 'Cape Verde',
            'KY' => 'Cayman Islands',
            'CF' => 'Central African Republic',
            'TD' => 'Chad',
            'CL' => 'Chile',
            'CN' => 'China',
            'CX' => 'Christmas Island',
            'CC' => 'Cocos Islands',
            'CO' => 'Colombia',
            'KM' => 'Comoros',
            'CD' => 'Congo Drc',
            'CK' => 'Cook Islands',
            'CR' => 'Costa Rica',
            'CI' => 'Cote D Ivoire',
            'HR' => 'Croatia',
            'CU' => 'Cuba',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'DK' => 'Denmark',
            'DJ' => 'Djibouti',
            'DM' => 'Dominica',
            'DO' => 'Dominican Republic',
            'EC' => 'Ecuador',
            'EG' => 'Egypt',
            'SV' => 'El Salvador',
            'GQ' => 'Equatorial Guinea',
            'ER' => 'Eritrea',
            'EE' => 'Estonia',
            'ET' => 'Ethiopia',
            'FK' => 'Falkland Islands',
            'FO' => 'Faroe Islands',
            'FJ' => 'Fiji',
            'FI' => 'Finland',
            'FR' => 'France',
            'GF' => 'French Guiana',
            'PF' => 'French Polynesia',
            'TF' => 'French Southern Territories',
            'GA' => 'Gabon',
            'GM' => 'Gambia',
            'GE' => 'Georgia',
            'DE' => 'Germany',
            'GH' => 'Ghana',
            'GI' => 'Gibraltar',
            'GR' => 'Greece',
            'GL' => 'Greenland',
            'GD' => 'Grenada',
            'GP' => 'Guadeloupe',
            'GU' => 'Guam',
            'GT' => 'Guatemala',
//            'GN' => 'Guinea',
            'GW' => 'Guinea Bissau',
            'GY' => 'Guyana',
            'HT' => 'Haiti',
            'VA' => 'Holy See (Vatican City State)',
            'HN' => 'Honduras',
            'HK' => 'Hong Kong',
            'HU' => 'Hungary',
            'IS' => 'Iceland',
            'IN' => 'India',
            'ID' => 'Indonesia',
            'IR' => 'Iran',
            'IQ' => 'Iraq',
            'IE' => 'Ireland',
            'IL' => 'Israel',
            'IT' => 'Italy',
            'JM' => 'Jamaica',
            'JP' => 'Japan',
            'JO' => 'Jordan',
            'KZ' => 'Kazakhstan',
            'KE' => 'Kenya',
            'KI' => 'Kiribati',
            'KR' => 'Korea',
            'KW' => 'Kuwait',
            'KG' => 'Kyrgyzstan',
            'LA' => 'Lao',
            'LV' => 'Latvia',
            'LB' => 'Lebanon',
            'LS' => 'Lesotho',
            'LR' => 'Liberia',
            'LY' => 'Libyan Arab Jamahiriya',
            'LI' => 'Liechtenstein',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'MO' => 'Macau',
            'MK' => 'Macedonia',
            'MG' => 'Madagascar',
            'MW' => 'Malawi',
            'MY' => 'Malaysia',
            'MV' => 'Maldives',
            'ML' => 'Mali',
            'MT' => 'Malta',
            'MH' => 'Marshall Islands',
            'MQ' => 'Martinique',
            'MR' => 'Mauritania',
            'MU' => 'Mauritius',
            'YT' => 'Mayotte',
            'MX' => 'Mexico',
            'FM' => 'Micronesia',
            'MD' => 'Moldova',
            'MC' => 'Monaco',
            'MN' => 'Mongolia',
            'MS' => 'Montserrat',
            'MA' => 'Morocco',
            'MZ' => 'Mozambique',
            'MM' => 'Myanmar',
            'NA' => 'Namibia',
            'NR' => 'Nauru',
            'NP' => 'Nepal',
            'NL' => 'Netherlands',
            'NC' => 'New Caledonia',
            'NZ' => 'New Zealand',
            'NI' => 'Nicaragua',
            'NE' => 'Niger',
            'NG' => 'Nigeria',
            'NU' => 'Niue',
            'NF' => 'Norfolk Island',
            'MP' => 'Northern Mariana Islands',
            'NO' => 'Norway',
            'OM' => 'Oman',
            'PK' => 'Pakistan',
            'PW' => 'Palau',
            'PS' => 'Palestinian Territory',
            'PA' => 'Panama',
            'PG' => 'Papua New Guinea',
            'PY' => 'Paraguay',
            'PE' => 'Peru',
            'PH' => 'Philippines',
            'PN' => 'Pitcairn',
            'PL' => 'Poland',
            'PT' => 'Portugal',
            'PR' => 'Puerto Rico',
            'QA' => 'Qatar',
            'RE' => 'Reunion',
            'RO' => 'Romania',
            'RW' => 'Rwanda',
            'SH' => 'Saint Helena',
            'KN' => 'Saint Kitts And Nevis',
            'LC' => 'Saint Lucia',
            'PM' => 'Saint Pierre And Miquelon',
            'VC' => 'Saint Vincent And The Grenadines',
            'WS' => 'Samoa',
            'SM' => 'San Marino',
            'ST' => 'Sao Tome And Principe',
            'SA' => 'Saudi Arabia',
            'SN' => 'Senegal',
            'SC' => 'Seychelles',
            'SL' => 'Sierra Leone',
            'SG' => 'Singapore',
            'SK' => 'Slovakia',
            'SI' => 'Slovenia',
            'SB' => 'Solomon Islands',
            'SO' => 'Somalia',
            'ZA' => 'South Africa',
            //'GS' => 'South Georgia And The South Sandwich Islands',
            'ES' => 'Spain',
            'LK' => 'Sri Lanka',
            'SD' => 'Sudan',
            'SR' => 'Suriname',
            'SJ' => 'Svalbard And Jan Mayen',
            'SZ' => 'Swaziland',
            'SE' => 'Sweden',
            'CH' => 'Switzerland',
            'TW' => 'Taiwan',
            'TJ' => 'Tajikistan',
            'TZ' => 'Tanzania',
            'TH' => 'Thailand',
            'TG' => 'Togo',
            'TK' => 'Tokelau',
            'TO' => 'Tonga',
            'TT' => 'Trinidad And Tobago',
            'TN' => 'Tunisia',
            'TR' => 'Turkey',
            'TM' => 'Turkmenistan',
//            'TC' => 'Turks And Caicos Islands',
            'TV' => 'Tuvalu',
            'UG' => 'Uganda',
            'UA' => 'Ukraine',
            'AE' => 'United Arab Emirates',
            'GB' => 'United Kingdom',
            'US' => 'United States',
            'UM' => 'United States Minor Outlying Islands',
            'UY' => 'Uruguay',
            'UZ' => 'Uzbekistan',
            'VU' => 'Vanuatu',
            'VE' => 'Venezuela',
            'VN' => 'Vietnam',
            'WF' => 'Wallis And Futuna',
            'EH' => 'Western Sahara',
            'YE' => 'Yemen',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe',
        );
        return $countries;
    }

    public static function childTimezone() {
        $options = array(
            'none' => '--Select Timezone--', 'Afghanistan/Kabul' => 'GMT+04:30 Kabul',
            'Aland Island/Helsinki' => 'GMT+02:00 Helsinki',
            'Albania/Tirane' => 'GMT+01:00 Tirane',
            'Algeria/Algiers' => 'GMT+01:00 Algiers',
            'Andorra/Andorra' => 'GMT+01:00 Andorra',
            'Angola/Lagos' => 'GMT+01:00 Lagos',
            'American Samoa/Pago_Pago' => 'GMT-11:00 Pago Pago',
            'Antarctica/Rothera' => 'GMT-03:00 Rothera',
            'Antarctica/Syowa' => 'GMT+03:00 Showa',
            'Antarctica/Mawson' => 'GMT+05:00 Mawson',
            'Antarctica/Vostok' => 'GMT+06:00 Vostok',
            'Antarctica/Davis' => 'GMT+07:00 Davis',
            'Antarctica/Casey' => 'GMT+08:00 Casey',
            'Antarctica/DumontDUrville' => "GMT+10:00 Dumont D'Urville",
            'Antarctica/Funafuti' => 'GMT+12:00 Auckland',
            'Anquilla/Port_of_Spain' => 'GMT-04:00 Port of Spain',
            'Antigua And Barbuda/Port_of_Spain' => 'GMT-04:00 Port of Spain',
            'Argentina/Buenos Aires' => 'GMT-03:00 Buenos Aires',
            'Armenia/Yerevan' => 'GMT+04:00 Yerevan',
            'Aruba/Curacao' => 'GMT-04:00 Curacao',
            'Ascension Island/Abidjan' => 'GMT+00:00 Abidjan',
            'Australia/Perth' => 'GMT+08:00  (AWST) Perth',
            'Australia/Eucla' => 'GMT+08:45 (ACWST) Eucla',
            'Australia/Adelaide' => 'GMT+09:30 (ACST) Darwin',
            'Australia/Brisbane' => 'GMT+10:00 (AEST) Sydney, Brisbane',
            'Austria/Vienna' => 'GMT+01:00 Vienna',
            'Azerbaijan/Baku' => 'GMT+04:00 Baku',
            'Bahamas/Nassau' => 'GMT-05:00 Nassau',
            'Bahrain/Qatar' => 'GMT+03:00 Qatar',
            'Bangladesh/Dhaka' => 'GMT+06:00 Dhaka',
            'Barbados/Barbados' => 'GMT-04:00 Barbados',
            'Belarus/Minsk' => 'GMT+03:00 Minsk',
            'Belgium/Brussels' => 'GMT+01:00 Brussels',
            'Belize/Belize' => 'GMT-06:00 Belize',
            'Benin/Lagos' => 'GMT+01:00 Lagos',
            'Bermuda/Bermuda' => 'GMT-04:00 Bermuda',
            'Bhutan/Thimphu' => 'GMT+06:00 Thimphu',
            'Bolivia/La_Paz' => 'GMT-04:00 La Paz',
            'Bonaire_Bermuda/Bermuda' => 'GMT-04:00 Bonaire',
            'Bosnia And Herzegovina/Belgrade' => 'GMT+01:00 Central European Time - Belgrade',
            'Botswana/Maputo' => 'GMT+02:00 Maputo',
            'Bouvet Island/Abidjan' => 'GMT +00:00 Abidjan',
            'Brazil/New_York' => 'GMT-05:00 Rio Blanco',
            'Brazil/Boa_Vista' => 'GMT-04:00 Boa Vista',
            'Brazil/Cayenne' => 'GMT-03:00 Sao Paolo',
            'Brazil/Campo_Grande' => 'GMT-03:00 Noronha',
            'British Indian Ocean Territory/Chagos' => 'GMT+06:00 Chagos',
            'British Virgin Islands/Port_of_Spain' => 'GMT-04:00 Port of Spain',
            'Brueni/Brunel' => 'GMT+08:00 Brunei',
            'Bulgaria/Sofia' => 'GMT+02:00 Sofia',
            'Burkina Faso/Abidjan' => 'GMT +00:00 Abidjan',
            'Burundi/Mapato' => 'GMT+02:00 Mapato',
            'Cambodia/Bangkok' => 'GMT+07:00 Bangkok',
            'Cameroon/Lagos' => 'GMT+01:00 Lagos',
            'Canary Islands/Abidjan' => 'GMT+00:00 Abidjan',
            'Canada/Vancouver' => 'GMT-08:00 (PST) Vancouver, Whitehorse',
            'Canada/Dawson_Creek' => 'GMT-07:00 (MST) Dawson Creek',
            'Canada/Edmonton' => 'GMT-07:00 (MST) Edmonton, Yellowknife',
            'Canada/Regina' => 'GMT-06:00 (CST) Regina',
            'Canada/Winnipeg' => 'GMT-06:00 (CST) Winnepeg',
            'Canada/Toronto' => 'GMT-05:00 (EST) Iqaluit, Toronto',
            'Canada/Halifax' => 'GMT-04:00 (AST) Halifax',
            'Canada/St_Johns' => 'GMT-03:30 (NST) Newfoundland',
            'Cape Verde/Cape_Verde' => 'GMT-01:00 Cape Verde',
            'Caribbean Netherlands/Curacao' => 'GMT-04:00 Curacao',
            'Cayman Islands/Panama' => 'GMT-05:00 Panama',
            'Central African Republic/Lagos' => 'GMT+01:00 Lagos',
            'Ceuta & Melilla/Ceuta' => 'GMT+01:00 Ceuta',
            'Chad/Ndjamena' => 'GMT+01:00 Ndjamena',
            'Chile/Easter' => 'GMT-05:00 Easter Island',
            'Chile/Santiago' => 'GMT-03:00 Santiago',
            'China/Hong_Kong' => 'GMT+08:00 China Time - Beijing',
            'Clipperton Island_clipperton/Clipperton' => 'GMT-07:00 Clipperton',
            'Cocos Islands/Cocos' => 'GMT+06:30 Cocos',
            "Cote D Ivoire/Abidjan" => 'GMT+00:00 Abidjan',
            'Colombia/Bogota' => 'GMT-05:00 Bogota',
            'Comoros/Nairobi' => 'GMT+03:00 Nairobi',
            'Costa Rica/Costa_Rica' => 'GMT-06:00 Costa Rica',
            'Congo DRC/Lagos' => 'GMT+01:00 Kinshasa',
            'Congo DRC/Maputo' => 'GMT+02:00 Lubumbashi',
            'Congo DRC/Lagos' => 'GMT+01:00 Lagos',
            'Cook Islands/Rarotonga' => 'GMT-10:00 Rarotonga',
            'Croatia/Belgrade' => 'GMT+01:00 Central European Time - Belgrade',
            'Cuba/Havana' => 'GMT-05:00 Havana',
            'Curacao/Curacao_c' => 'GMT-04:00 Curacao',
            'Cyprus/Nicosia' => 'GMT+02:00 Nicosia',
            'Czech Republic/Prague' => 'GMT+01:00 Central European Time - Prague',
            'Denmark/Copenhagen' => 'GMT+01:00 Copenhagen',
            'Diego Garcia/Chagos' => 'GMT+06:00 Diego Garcia',
            'Djibouti/Nairobi' => 'GMT+03:00 Nairobi',
            'Dominica/Port_of_Spain' => 'GMT-04:00 Port of Spain',
            'Dominican Republic/Santo_Domingo' => 'GMT-04:00 Santo Domingo',
            'Ecuador/Galapagos' => 'GMT-06:00 Galapagos',
            'Ecuador/Guayaquil' => 'GMT-05:00 Guayaquil',
            'Egypt/Cairo' => 'GMT+02:00 Cairo',
            'El Salvador/El_Salvador' => 'GMT-06:00 El Salvador',
            'Equatorial Guinea/Lagos' => 'GMT+01:00 Lagos',
            'Eritrea/Nairobi' => 'GMT+03:00 Nairobi',
            'Estonia/Tallinn' => 'GMT+02:00 Tallinn',
            'Ethiopia/Nairobi' => 'GMT+03:00 Nairobi',
            'Falkland Islands/Stanley' => 'GMT-03:00 Stanley',
            'Faroe Islands/Abidjan' => 'GMT+00:00 Faeroe',
            'Fiji/Fiji' => 'GMT+13:00 Fiji',
            'Finland/Helsinki' => 'GMT+02:00 Helsinki',
            'France/Paris' => 'GMT+01:00 Paris',
            'French Guiana/Cayenne' => 'GMT-03:00 Cayenne',
            'French Polynesia/Tahiti' => 'GMT-10:00 Tahiti',
            'French Polynesia/Marquesas' => 'GMT-09:30 Marquesas',
            'French Polynesia/Gambier' => 'GMT-09:00 Gambier',
            'French Southern Territories/Kerguelen' => 'GMT+05:00 Kerguelen',
            'Gabon/Lagos' => 'GMT+01:00 Lagos',
            'Gambia/Abidjan' => 'GMT +00:00 Abidjan',
            'Georgia/Tbilisi' => 'GMT+04:00 Tbilisi',
            'Germany/Berlin' => 'GMT+01:00 Berlin',
            'Ghana/Accra' => 'GMT+00:00 Accra',
            'Gibraltar/Gibraltar' => 'GMT+01:00 Gibraltar',
            'Greece/Athens' => 'GMT+02:00 Athens',
            'Greenland/Fortaleza' => 'GMT-03:00 Thule',
            'Greenland/Godthab' => 'GMT-03:00 Godthab',
            'Greenland/Scoresbysund' => 'GMT-01:00 Scoresbysund',
            'Greenland/Danmarkshavn' => 'GMT+00:00 Danmarkshavn',
            'Grenada/Port_of_Spain' => 'GMT-04:00 Port of Spain',
            'Guadeloupe/Port_of_Spain' => 'GMT-04:00 Port of Spain',
            'Guam/Guam' => 'GMT+10:00 Guam',
            'Guatemala/Guatemala' => 'GMT-06:00 Guatemala',
            'Guernsey/Londan' => 'GMT+00:00 Guernsey',
            'GuineaGuinee/Abidjan' => 'GMT +00:00 Abidjan',
            'Guinea Bissau/Bissau' => 'GMT+00:00 Bissau',
            'Guyana/Guyana' => 'GMT-04:00 Guyana',
            'Haiti/Port-au-Prince' => 'GMT-05:00 Port au-Prince',
            'Heard And McDonald Islands/Kerguelen' => 'GMT +05:00 Kerguelen',
            'Honduras/Tegucigalpa' => 'GMT-06:00 Central Time - Tegucigalpa',
            'Hong Kong/Hong_Kong' => 'GMT+08:00 Hong Kong',
            'Hungary/Budapest' => 'GMT+01:00 Budapest',
            'Iceland/Reykjavik' => 'GMT +00:00 Reykjavik',
            'India/Kolkata' => 'GMT+05:30 India Standard Time',
            'Indonesia/Jakarta' => 'GMT+07:00 Jakarta',
            'Indonesia/Makassar' => 'GMT+08:00 Makassar',
            'Indonesia/Pontianak' => 'GMT+07:00 Pontianak',
            'Iran/Tehran' => 'GMT+03:30 Tehran',
            'Iraq/Baghdad' => 'GMT+03:00 Baghdad',
            'Ireland/Dublin' => 'GMT+00:00 Dublin',
            'Isle of Man/London' => 'GMT +00:00 London',
            'Israel/Jerusalem' => 'GMT+02:00 Jerusalem',
            'Italy/Rome' => 'GMT+01:00 Rome',
            'Jamaica/Jamaica' => 'GMT-05:00 Jamaica',
            'Japan/Tokyo' => 'GMT+09:00 Tokyo',
            'Jersey/London' => 'GMT+00:00 London',
            'Jordan/Amman' => 'GMT+02:00 Amman',
            'Kazakhstan/Almaty' => 'GMT+06:00  Astana',
            'Kazakhstan/Aqtobe' => 'GMT+05:00  Aqtobe',
            'Kazakhstan/Bishkek' => 'GMT +06:00 Almaty',
            'Kenya/Nairobi' => 'GMT+03:00 Nairobi',
            'Kiribati/Tarawa' => 'GMT +12:00 Tarawa',
            'Kiribati/Enderbury' => 'GMT+13:00 Phoenix Islands',
            'Kiribati/Kiritimati' => 'GMT+14:00 Kiritimati',
            'Christmas Island/Kiritimati' => 'GMT+14:00 Kiritimati',
            'Kosovo/Belgrade' => 'GMT+01:00 Central European Time',
            'Kuwait/Riyadh' => 'GMT+03:00 Riyadh',
            'Kyrgyzstan/Bishkek' => 'GMT+06:00 Bishkek',
            'Lao/Bangkok' => 'GMT+07:00 Bangkok',
            'Latvia/Riga' => 'GMT+02:00 Riga',
            'Lebanon/Beirut' => 'GMT+02:00 Beirut',
            'Lesotho/Johannesburg' => 'GMT+02:00 Johannesburg',
            'Liberia/Monrovia' => 'GMT+00:00 Monrovia',
            'Libyan Arab Jamahiriya/Monrovia' => 'GMT+00:00 Monrovia',
            'Libya/Tripoli' => 'GMT+02:00 Tripoli',
            'Liechtenstein/Zurich' => 'GMT+01:00 Zurich',
            'Lithuania/Vilnius' => 'GMT+02:00 Vilnius',
            'Lord Howe Island/Lord_Howe' => 'GMT+11:00 Lord Howe Island',
            'Luxembourg/Luxembourg' => 'GMT+01:00 Luxembourg',
            'Macau/Macau' => 'GMT+08:00 Macau',
            'Macedonia/Belgrade' => 'GMT+01:00 Central European Time - Belgrade',
            'Madagascar/Nairobi' => 'GMT+03:00 Nairobi',
            'Malawi/Mapato' => 'GMT+02:00 Mapato',
            'Malaysia/Kuala_Lumpur' => 'GMT+08:00 Kuala Lumpur',
            'Maldives/Maldives' => 'GMT+05:00 Maldives',
            'Mali/Abidjan' => 'GMT+00:00 Abidjan',
            'Malta/Malta' => 'GMT+01:00 Malta',
            'Marshall Islands/Kwajalein' => 'GMT+12:00 Kwajalein',
            'Marshall Islands/Majuro' => 'GMT+12:00 Majuro',
            'Martinique/Martinique' => 'GMT-04:00 Martinique',
            'Mauritania/Abidjan' => 'GMT +00:00 Abidjan',
            'Mauritius/Mauritius' => 'GMT+04:00 Mauritius',
            'Mayotte/Nairobi' => 'GMT+03:00 Nairobi',
            'Mexico/Tijuana' => 'GMT-08:00 Pacific Time - Tijuana',
            'Mexico/Hermosillo' => 'GMT-07:00 Mountain Time - Hermosillo',
            'Mexico/Mexico_City' => 'GMT-06:00 Central Time - Mexico City',
            'Mexico/Cayman' => 'GMT-05:00 America Cancun',
            'Micronesia/Port_Moresby' => 'GMT+10:00 Truk',
            'Micronesia/Kosrae' => 'GMT+11:00 Kosrae',
            'Micronesia/Pohnpei' => 'GMT+11:00 Pohnpei',
            'Moldova/Chisinau' => 'GMT+02:00 Chinisau',
            'Monaco/Monaco' => 'GMT+01:00 Monaco',
            'Mongolia/Hovd' => 'GMT+07:00 Hovd',
            'Mongolia/Choibalsan' => 'GMT+08:00 Choibalsan',
            'Mongolia/Ulaanbaatar' => 'GMT+08:00 Ulaanbaatar',
            'Montenegro/Belgrade' => 'GMT+01:00 Central European Time - Belgrade',
            'Montserrat/Port_of_Spain' => 'GMT-04:00 Port of Spain',
            'Morocco/Casablanca' => 'GMT+00:00 Casablanca',
            'Mozambique/Maputo' => 'GMT+02:00 Mapato',
            'Myanmar/Rangoon' => 'GMT+06:30 Rangoon',
            'Namibia/Windhoek' => 'GMT+02:00 Windhoek',
            'Nauru/Nauru' => 'GMT+12:00 Nauru',
            'Nepal/Kathmandu' => 'GMT+05:45 Kathmandu',
            'Netherlands/Amsterdam' => 'GMT+01:00 Amsterdam',
            'New Caledonia/Noumea' => 'GMT+11:00 Noumea',
            'New Zealand/Kwajalein' => 'GMT+12:00 Auckland',
            'Nicaragua/Managua' => 'GMT-06:00 Managua',
            'Niger_lagos/Lagos' => 'GMT+01:00 Lagos',
            'Nigeria/Lagos' => 'GMT+01:00 Lagos',
            'Niue/Niue' => 'GMT-11:00 Niue',
            'Norfolk Island/Noumea' => 'GMT+11:00 Norfolk',
            'Northern Mariana Islands/Guam' => 'GMT+10:00 Guam',
            'Korea/Pyongyang' => 'GMT+08:30 Pyongyang',
            'Norway/Oslo' => 'GMT+01:00 Oslo',
            'Oman/Dubai' => 'GMT+04:00 Dubai',
            'Pakistan/Karachi' => 'GMT+05:00 Karachi',
            'Palau/Palau' => 'GMT+09:00 Palau',
            'Palestinian Territory/Gaza' => 'GMT+03:00 Gaza',
            'Panama/Panama' => 'GMT-05:00 Panama',
            'Papua New Guinea/Saipan' => 'GMT+10:00 Port Moresby',
            'Papua New Guinea/Port_Moresby' => 'GMT+11:00 Autonomous Region',
            'Paraguay/Stanley' => 'GMT-03:00 Ascuncion',
            'Peru/Lima' => 'GMT-05:00 Lima',
            'Philippines/Manila' => 'GMT+08:00 Manila',
            'Pitcairn/Pitcairn' => 'GMT-08:00 Pitcairn',
            'Poland/Warsaw' => 'GMT+01:00 Warsaw',
            'Portugal/Azores' => 'GMT-01:00 Azores',
            'Portugal/Lisbon' => 'GMT+00:00 Lisbon',
            'Puerto Rico/Puerto_Rico' => 'GMT-04:00 Puerto Rico',
            'Qatar/Qatar' => 'GMT+03:00 Qatar',
            'Reunion/Reunion' => 'GMT+04:00 Reunion',
            'Romania/Bucharest' => 'GMT+02:00 Bucharest',
            'Russia/Kiev' => 'GMT+02:00 Kaliningrad',
            'Russia/Kaliningrad' => 'GMT+03:00 Moscow',
            'Russia/Samara' => 'GMT+04:00 Samara',
            'Russia/Tashkent' => 'GMT+05:00 Yekaterinburg',
            'Russia/Omsk' => 'GMT+07:00 Omsk',
            'Russia/Novokuznetsk' => 'GMT+07:00 Krasnoyarsk',
            'Russia/Irkutsk' => 'GMT+09:00 Irkutsk',
            'Russia/Jayapura' => 'GMT+09:00 Yakutsk',
            'Russia/Vladivostok' => 'GMT+11:00 Vladivostok',
            'Russia/Magadan' => 'GMT+12:00 Magadan',
            'Russia/Kamchatka' => 'GMT+12:00 Petropavlovsk-Kamchatskly',
            'Rwanda/Mapato' => 'GMT+02:00 Mapato',
            'Saba/Anguilla' => 'GMT-04:00 Saba',
            'Samoa/Auckland' => 'GMT+13:00 Apia',
            'San Marino/Rome' => 'GMT+01:00 Rome',
            'Sao Tome & Principe/Abidjan' => 'GMT+00:00 Abidjan',
            'Saudi Arabia/Riyadh' => 'GMT+03:00 Riyadh',
            'Scotland_Abidjan/Abidjan' => 'GMT +00:00 Edinburgh',
            'Senegal/Abidjan' => 'GMT+00:00 Abidjan',
            'Serbia/Belgrade' => 'GMT+01:00 Central European Time - Belgrade',
            'Seychelles/Mahe' => 'GMT+04:00 Mahe',
            'Sierra Leone/Abidjan' => 'GMT+00:00 Abidjan',
            'Singapore/Singapore' => 'GMT+08:00 Singapore',
            'Sint Maarten/Curacao' => 'GMT-04:00 Curacao',
            'Slovakia/Prague' => 'GMT+01:00 Central European Time - Prague',
            'Slovenia/Belgrade' => 'GMT+01:00 Central European Time - Belgrade',
            'Solomon Islands/Guadalcanal' => 'GMT+11:00 Guadalcanal',
            'Somalia/Nairobi' => 'GMT+03:00 Nairobi',
            'South Africa/Johannesburg' => 'GMT+02:00 Johannesburg',
            'South Georgia And South Sandwich Islands/South_Georgia' => 'GMT-02:00 South Georgia',
            'Korea/Seoul' => 'GMT+09:00 Seoul',
            'South Sudan/Khartoum' => 'GMT+03:00 Khartoum',
            'Spain/Canary' => 'GMT+00:00 Canary Islands',
            'Spain/Ceuta' => 'GMT+01:00 (CET) Ceuta',
            'Spain/Madrid' => 'GMT+01:00 Madrid',
            'Sri Lanka/Colombo' => 'GMT+05:30 Colombo',
            'Saint Barthelemy/St_Barthelemy' => 'GMT-04:00 St. Barthelemy',
            'Saint Helena/Abidjan' => 'GMT+00:00 Abidjan',
            'Saint Kitts And Nevis/Port_of_Spain' => 'GMT-04:00 Port of Spain',
            'Saint Lucia/Port_of_Spain' => 'GMT-04:00 Port of Spain',
            'Saint  Martin/Port_of_Spain' => 'GMT-04:00 Port of Spain',
            'Saint Pierre And Miquelon/Miquelon' => 'GMT-03:00 Miquelon',
            'Saint Vincent And The Grenadines/Port_of_Spain' => 'GMT-04:00 Port of Spain',
            'Sudan/Khartoum' => 'GMT+03:00 Khartoum',
            'Suriname/Paramaribo' => 'GMT-03:00 Paramaribo',
            'Svalbard And Jan Mayen/Oslo' => 'GMT+01:00 Oslo',
            'Swaziland/Johannesburg' => 'GMT+02:00 Johannesburg',
            'Sweden/Stockholm' => 'GMT+01:00 Stockholm',
            'Switzerland/Zurich' => 'GMT+01:00 Zurich',
            'Syria/Damascus' => 'GMT+02:00 Damascus',
            'Taiwan/Taipei' => 'GMT+08:00 Taipei',
            'Tajikistan/Dushanbe' => 'GMT+05:00 Dushanbe',
            'Tanzania/Nairobi' => 'GMT+03:00 Nairobi',
            'Thailand/Bangkok' => 'GMT+07:00 Bangkok',
            'Timor-Leste/Dili' => 'GMT+09:00 Dili',
            'Togo/Abidjan' => 'GMT+00:00 Abidjan',
            'Tokelau/Fakaofo' => 'GMT+13:00 Fakaofo',
            'Tonga/Kiritimati' => 'GMT+14:00 Tongatapu',
            'Trinidad And Tobago/Port_of_Spain' => 'GMT-04:00 Port of Spain',
            'Tristan da Cunha/Abidjan' => 'GMT+00:00 Abidjan',
            'Tunisia/Tunis' => 'GMT+01:00 Tunis',
            'Turkey/Istanbul' => 'GMT+03:00 Istanbul',
            'Turkmenistan/Ashgabat' => 'GMT+05:00 Ashgabat',
            'Turks And Caicos Island/Grand_Turk' => 'GMT-04:00 Grand Turk',
            'Tuvalu/Funafuti' => 'GMT+12:00 Funafuti',
            'U.S. Outlying Islands/Pago_Pago' => 'GMT-11:00 Pago Pago',
            'U.S. Outlying Islands/Honolulu' => 'GMT-10:00 Hawaii Time',
            'U.S. Outlying Islands/Wake' => 'GMT+12:00 Wake',
            'U.S. Outlying Islands/Enderbury' => 'GMT+13:00 Enderbury',
            'U.S. Virgin Islands/Port_of_Spain' => 'GMT-04:00 Port of Spain',
            'Uganda/Nairobi' => 'GMT+03:00 Nairobi',
            'Ukraine/Kiev' => 'GMT+02:00 Kiev',
            'United Arab Emirates/Dubai' => 'GMT+04:00 Dubai',
            'United Kingdom/London' => 'GMT+00:00 London',
            'United States/Honolulu' => 'GMT-10:00 Hawaii Time',
            'United States/Anchorage' => 'GMT-09:00 Alaska Time',
            'United States/Los_Angeles' => 'GMT-08:00 Pacific Time',
            'United States/Denver' => 'GMT-07:00 Mountain Time',
            'United States/Dawson' => 'GMT-07:00 Mountain Time (Arizona)',
            'United States/Chicago' => 'GMT-06:00 Central Time',
            'United States/Cayman' => 'GMT-05:00 Eastern Time',
            'Uruguay/Montevideo' => 'GMT-03:00 Montevideo',
            'Uzbekistan/Tashkent' => 'GMT+05:00 Tashkent',
            'Vanuatu/Efate' => 'GMT+11:00 Efate',
            'Vatican City/Rome' => 'GMT+01:00 Rome',
            'Venezuela/Caracas' => 'GMT-04:00 Caracas',
            'Vietnam/Ho_Chi_Minh' => 'GMT+07:00 Hanoi',
            'Wallis And Futuna/Wallis' => 'GMT+12:00 Wallis',
            'Wales/Abidjan' => 'GMT+00:00 Cardiff',
            'Western Sahara/El_Aaiun' => 'GMT+00:00 Abidjan',
            'Yemen/Riyadh' => 'GMT+03:00 Riyadh',
            'Zambia/Maputo' => 'GMT+02:00 Maputo',
            'Zimbabwe/Maputo' => 'GMT+02:00 Maputo',
             
        );
        return $options;
    }

    public static function country_to_continent($country) {
        $continent = '';
        if ($country == 'AF')
            $continent = 'Asia';
        if ($country == 'AX')
            $continent = 'Europe';
        if ($country == 'AL')
            $continent = 'Europe';
        if ($country == 'DZ')
            $continent = 'Africa';
        if ($country == 'AS')
            $continent = 'Australia';
        if ($country == 'AD')
            $continent = 'Europe';
        if ($country == 'AO')
            $continent = 'Africa';
        if ($country == 'AI')
            $continent = 'America';
        if ($country == 'AQ')
            $continent = 'Antarctica';
        if ($country == 'AG')
            $continent = 'America';
        if ($country == 'AR')
            $continent = 'America';
        if ($country == 'AM')
            $continent = 'Asia';
        if ($country == 'AW')
            $continent = 'America';
        if ($country == 'AU')
            $continent = 'Australia';
        if ($country == 'AT')
            $continent = 'Europe';
        if ($country == 'AZ')
            $continent = 'Asia';
        if ($country == 'BS')
            $continent = 'America';
        if ($country == 'BH')
            $continent = 'Asia';
        if ($country == 'BD')
            $continent = 'Asia';
        if ($country == 'BB')
            $continent = 'America';
        if ($country == 'BY')
            $continent = 'Europe';
        if ($country == 'BE')
            $continent = 'Europe';
        if ($country == 'BZ')
            $continent = 'America';
        if ($country == 'BJ')
            $continent = 'Africa';
        if ($country == 'BM')
            $continent = 'Atlantic';
        if ($country == 'BT')
            $continent = 'Asia';
        if ($country == 'BO')
            $continent = 'America';
        if ($country == 'BA')
            $continent = 'Europe';
        if ($country == 'BW')
            $continent = 'Africa';
        if ($country == 'BV')
            $continent = 'Antarctica';
        if ($country == 'BR')
            $continent = 'America';
        if ($country == 'IO')
            $continent = 'Asia';
        if ($country == 'VG')
            $continent = 'America';
        if ($country == 'BN')
            $continent = 'Asia';
        if ($country == 'BG')
            $continent = 'Europe';
        if ($country == 'BF')
            $continent = 'Africa';
        if ($country == 'BI')
            $continent = 'Africa';
        if ($country == 'KH')
            $continent = 'Asia';
        if ($country == 'CM')
            $continent = 'Africa';
        if ($country == 'CA')
            $continent = 'America';
        if ($country == 'CV')
            $continent = 'Africa';
        if ($country == 'KY')
            $continent = 'America';
        if ($country == 'CF')
            $continent = 'Africa';
        if ($country == 'TD')
            $continent = 'Africa';
        if ($country == 'CL')
            $continent = 'Pacific';
        if ($country == 'CN')
            $continent = 'Asia';
        if ($country == 'CX')
            $continent = 'Asia';
        if ($country == 'CC')
            $continent = 'Asia';
        if ($country == 'CO')
            $continent = 'America';
        if ($country == 'KM')
            $continent = 'Africa';
        if ($country == 'CD')
            $continent = 'Africa';
        if ($country == 'CG')
            $continent = 'Africa';
        if ($country == 'CK')
            $continent = 'Pacific';
        if ($country == 'CR')
            $continent = 'America';
        if ($country == 'CI')
            $continent = 'Africa';
        if ($country == 'HR')
            $continent = 'Europe';
        if ($country == 'CU')
            $continent = 'America';
        if ($country == 'CY')
            $continent = 'Asia';
        if ($country == 'CZ')
            $continent = 'Europe';
        if ($country == 'DK')
            $continent = 'Europe';
        if ($country == 'DJ')
            $continent = 'Africa';
        if ($country == 'DM')
            $continent = 'America';
        if ($country == 'DO')
            $continent = 'America';
        if ($country == 'EC')
            $continent = 'Pacific';
        if ($country == 'EG')
            $continent = 'Africa';
        if ($country == 'SV')
            $continent = 'America';
        if ($country == 'GQ')
            $continent = 'Africa';
        if ($country == 'ER')
            $continent = 'Africa';
        if ($country == 'EE')
            $continent = 'Europe';
        if ($country == 'ET')
            $continent = 'Africa';
        if ($country == 'FO')
            $continent = 'Europe';
        if ($country == 'FK')
            $continent = 'America';
        if ($country == 'FJ')
            $continent = 'Pacific';
        if ($country == 'FI')
            $continent = 'Europe';
        if ($country == 'FR')
            $continent = 'Europe';
        if ($country == 'GF')
            $continent = 'America';
        if ($country == 'PF')
            $continent = 'Pacific';
        if ($country == 'TF')
            $continent = 'Antarctica';
        if ($country == 'GA')
            $continent = 'Africa';
        if ($country == 'GM')
            $continent = 'Africa';
        if ($country == 'GE')
            $continent = 'Asia';
        if ($country == 'DE')
            $continent = 'Europe';
        if ($country == 'GH')
            $continent = 'Africa';
        if ($country == 'GI')
            $continent = 'Europe';
        if ($country == 'GR')
            $continent = 'Europe';
        if ($country == 'GL')
            $continent = 'America';
        if ($country == 'GD')
            $continent = 'America';
        if ($country == 'GP')
            $continent = 'America';
        if ($country == 'GU')
            $continent = 'Pacific';
        if ($country == 'GT')
            $continent = 'America';
        if ($country == 'GG')
            $continent = 'Europe';
        if ($country == 'GN')
            $continent = 'Africa';
        if ($country == 'GW')
            $continent = 'Africa';
        if ($country == 'GY')
            $continent = 'America';
        if ($country == 'HT')
            $continent = 'America';
        if ($country == 'HM')
            $continent = 'Antarctica';
        if ($country == 'VA')
            $continent = 'Europe';
        if ($country == 'HN')
            $continent = 'America';
        if ($country == 'HK')
            $continent = 'Asia';
        if ($country == 'HU')
            $continent = 'Europe';
        if ($country == 'IS')
            $continent = 'Europe';
        if ($country == 'IN')
            $continent = 'Asia';
        if ($country == 'ID')
            $continent = 'Asia';
        if ($country == 'IR')
            $continent = 'Asia';
        if ($country == 'IQ')
            $continent = 'Asia';
        if ($country == 'IE')
            $continent = 'Europe';
        if ($country == 'IM')
            $continent = 'Europe';
        if ($country == 'IL')
            $continent = 'Asia';
        if ($country == 'IT')
            $continent = 'Europe';
        if ($country == 'JM')
            $continent = 'America';
        if ($country == 'JP')
            $continent = 'Asia';
        if ($country == 'JE')
            $continent = 'Europe';
        if ($country == 'JO')
            $continent = 'Asia';
        if ($country == 'KZ')
            $continent = 'Asia';
        if ($country == 'KE')
            $continent = 'Africa';
        if ($country == 'KI')
            $continent = 'Pacific';
        if ($country == 'KP')
            $continent = 'Asia';
        if ($country == 'KR')
            $continent = 'Asia';
        if ($country == 'KW')
            $continent = 'Asia';
        if ($country == 'KG')
            $continent = 'Asia';
        if ($country == 'LA')
            $continent = 'Asia';
        if ($country == 'LV')
            $continent = 'Europe';
        if ($country == 'LB')
            $continent = 'Asia';
        if ($country == 'LS')
            $continent = 'Africa';
        if ($country == 'LR')
            $continent = 'Africa';
        if ($country == 'LY')
            $continent = 'Africa';
        if ($country == 'LI')
            $continent = 'Europe';
        if ($country == 'LT')
            $continent = 'Europe';
        if ($country == 'LU')
            $continent = 'Europe';
        if ($country == 'MO')
            $continent = 'Asia';
        if ($country == 'MK')
            $continent = 'Europe';
        if ($country == 'MG')
            $continent = 'Africa';
        if ($country == 'MW')
            $continent = 'Africa';
        if ($country == 'MY')
            $continent = 'Asia';
        if ($country == 'MV')
            $continent = 'Asia';
        if ($country == 'ML')
            $continent = 'Africa';
        if ($country == 'MT')
            $continent = 'Europe';
        if ($country == 'MH')
            $continent = 'Pacific';
        if ($country == 'MQ')
            $continent = 'America';
        if ($country == 'MR')
            $continent = 'Africa';
        if ($country == 'MU')
            $continent = 'Africa';
        if ($country == 'YT')
            $continent = 'Africa';
        if ($country == 'MX')
            $continent = 'America';
        if ($country == 'FM')
            $continent = 'Pacific';
        if ($country == 'MD')
            $continent = 'Europe';
        if ($country == 'MC')
            $continent = 'Europe';
        if ($country == 'MN')
            $continent = 'Asia';
        if ($country == 'ME')
            $continent = 'Europe';
        if ($country == 'MS')
            $continent = 'America';
        if ($country == 'MA')
            $continent = 'Africa';
        if ($country == 'MZ')
            $continent = 'Africa';
        if ($country == 'MM')
            $continent = 'Asia';
        if ($country == 'NA')
            $continent = 'Africa';
        if ($country == 'NR')
            $continent = 'Pacific';
        if ($country == 'NP')
            $continent = 'Asia';
        if ($country == 'AN')
            $continent = 'America';
        if ($country == 'NL')
            $continent = 'Europe';
        if ($country == 'NC')
            $continent = 'Pacific';
        if ($country == 'NZ')
            $continent = 'Pacific';
        if ($country == 'NI')
            $continent = 'America';
        if ($country == 'NE')
            $continent = 'Africa';
        if ($country == 'NG')
            $continent = 'Africa';
        if ($country == 'NU')
            $continent = 'Pacific';
        if ($country == 'NF')
            $continent = 'Pacific';
        if ($country == 'MP')
            $continent = 'Pacific';
        if ($country == 'NO')
            $continent = 'Europe';
        if ($country == 'OM')
            $continent = 'Asia';
        if ($country == 'PK')
            $continent = 'Asia';
        if ($country == 'PW')
            $continent = 'Pacific';
        if ($country == 'PS')
            $continent = 'Asia';
        if ($country == 'PA')
            $continent = 'America';
        if ($country == 'PG')
            $continent = 'Pacific';
        if ($country == 'PY')
            $continent = 'America';
        if ($country == 'PE')
            $continent = 'America';
        if ($country == 'PH')
            $continent = 'Asia';
        if ($country == 'PN')
            $continent = 'Pacific';
        if ($country == 'PL')
            $continent = 'Europe';
        if ($country == 'PT')
            $continent = 'Europe';
        if ($country == 'PR')
            $continent = 'America';
        if ($country == 'QA')
            $continent = 'Asia';
        if ($country == 'RE')
            $continent = 'Africa';
        if ($country == 'RO')
            $continent = 'Europe';
        if ($country == 'RU')
            $continent = 'Europe';
        if ($country == 'RW')
            $continent = 'Africa';
        if ($country == 'BL')
            $continent = 'America';
        if ($country == 'SH')
            $continent = 'Africa';
        if ($country == 'KN')
            $continent = 'America';
        if ($country == 'LC')
            $continent = 'America';
        if ($country == 'MF')
            $continent = 'America';
        if ($country == 'PM')
            $continent = 'America';
        if ($country == 'VC')
            $continent = 'America';
        if ($country == 'WS')
            $continent = 'Pacific';
        if ($country == 'SM')
            $continent = 'Europe';
        if ($country == 'ST')
            $continent = 'Africa';
        if ($country == 'SA')
            $continent = 'Asia';
        if ($country == 'SN')
            $continent = 'Africa';
        if ($country == 'RS')
            $continent = 'Europe';
        if ($country == 'SC')
            $continent = 'Africa';
        if ($country == 'SL')
            $continent = 'Africa';
        if ($country == 'SG')
            $continent = 'Asia';
        if ($country == 'SK')
            $continent = 'Europe';
        if ($country == 'SI')
            $continent = 'Europe';
        if ($country == 'SB')
            $continent = 'Pacific';
        if ($country == 'SO')
            $continent = 'Africa';
        if ($country == 'ZA')
            $continent = 'Africa';
        if ($country == 'GS')
            $continent = 'Antarctica';
        if ($country == 'ES')
            $continent = 'Europe';
        if ($country == 'LK')
            $continent = 'Asia';
        if ($country == 'SD')
            $continent = 'Africa';
        if ($country == 'SR')
            $continent = 'America';
        if ($country == 'SJ')
            $continent = 'Europe';
        if ($country == 'SZ')
            $continent = 'Africa';
        if ($country == 'SE')
            $continent = 'Europe';
        if ($country == 'CH')
            $continent = 'Europe';
        if ($country == 'SY')
            $continent = 'Asia';
        if ($country == 'TW')
            $continent = 'Asia';
        if ($country == 'TJ')
            $continent = 'Asia';
        if ($country == 'TZ')
            $continent = 'Africa';
        if ($country == 'TH')
            $continent = 'Asia';
        if ($country == 'TL')
            $continent = 'Asia';
        if ($country == 'TG')
            $continent = 'Africa';
        if ($country == 'TK')
            $continent = 'Tokelau';
        if ($country == 'TO')
            $continent = 'Pacific';
        if ($country == 'TT')
            $continent = 'America';
        if ($country == 'TN')
            $continent = 'Africa';
        if ($country == 'TR')
            $continent = 'Asia';
        if ($country == 'TM')
            $continent = 'Asia';
        if ($country == 'TC')
            $continent = 'America';
        if ($country == 'TV')
            $continent = 'Pacific';
        if ($country == 'UG')
            $continent = 'Africa';
        if ($country == 'UA')
            $continent = 'Europe';
        if ($country == 'AE')
            $continent = 'Asia';
        if ($country == 'GB')
            $continent = 'Europe';
        if ($country == 'US')
            $continent = 'America';
        if ($country == 'UM')
            $continent = 'Pacific';
        if ($country == 'VI')
            $continent = 'America';
        if ($country == 'UY')
            $continent = 'America';
        if ($country == 'UZ')
            $continent = 'Asia';
        if ($country == 'VU')
            $continent = 'Pacific';
        if ($country == 'VE')
            $continent = 'America';
        if ($country == 'VN')
            $continent = 'Asia';
        if ($country == 'WF')
            $continent = 'Pacific';
        if ($country == 'EH')
            $continent = 'Africa';
        if ($country == 'YE')
            $continent = 'Asia';
        if ($country == 'ZM')
            $continent = 'Africa';
        if ($country == 'ZW')
            $continent = 'Africa';
        return $continent;
    }

}
