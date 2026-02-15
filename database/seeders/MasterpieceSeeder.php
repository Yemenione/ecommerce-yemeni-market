<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MasterpieceSeeder extends Seeder
{
    public function run(): void
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();

        // Clear existing data to avoid clutter
        \App\Models\Review::query()->delete();
        \App\Models\Wishlist::query()->delete();
        \App\Models\ProductVariant::query()->delete();
        \App\Models\FlashSale::query()->delete();
        Product::query()->delete();
        Category::query()->delete();

        $categories = [
            [
                'name' => [
                    'en' => 'Sidr Honey', 
                    'ar' => 'عسل السدر', 
                    'fr' => 'Miel de Sidr',
                    'de' => 'Sidr-Honig',
                    'es' => 'Miel de Sidr',
                    'it' => 'Miele di Sidr',
                    'nl' => 'Sidr-honing',
                    'tr' => 'Sidr Balı'
                ],
                'slug' => 'sidr-honey',
                'description' => [
                    'en' => 'The world\'s most prestigious honey, harvested from the sacred Sidr trees of Hadramout.',
                    'ar' => 'أفخر أنواع العسل في العالم، يُجمع من أشجار السدر المباركة في وادي حضرموت.',
                    'fr' => 'Le miel le plus prestigieux au monde, récolté sur les arbres sacrés de Sidr à Hadramout.',
                    'de' => 'Der prestigeträchtigste Honig der Welt, geerntet von den heiligen Sidr-Bäumen von Hadramout.',
                    'es' => 'La miel más prestigiosa del mundo, cosechada de los sagrados árboles Sidr de Hadramout.',
                    'it' => 'Il miele più prestigioso al mondo, raccolto dai sacri alberi di Sidr di Hadramout.',
                    'nl' => 'De meest prestigieuze honing ter wereld, geoogst van de heilige Sidr-bomen van Hadramout.',
                    'tr' => 'Hadramut\'un kutsal Sidr ağaçlarından hasat edilen, dünyanın en prestijli balı.'
                ],
                'image' => 'categories/honey.png'
            ],
            [
                'name' => [
                    'en' => 'Mocha Coffee', 
                    'ar' => 'بن موكا', 
                    'fr' => 'Café Mocha',
                    'de' => 'Mocha-Kaffee',
                    'es' => 'Café Mocha',
                    'it' => 'Caffè Mocha',
                    'nl' => 'Mocha-koffie',
                    'tr' => 'Mocha Kahvesi'
                ],
                'slug' => 'mocha-coffee',
                'description' => [
                    'en' => 'Ancient coffee heritage from the terraces of Haraz and Bani Mattar.',
                    'ar' => 'تراث البن العتيق من مدرجات حراز وبني مطر.',
                    'fr' => 'Héritage séculaire du café issu des terrasses de Haraz et Bani Mattar.',
                    'de' => 'Altes Kaffee-Erbe von den Terrassen von Haraz und Bani Mattar.',
                    'es' => 'Antigua herencia de café de las terrazas de Haraz y Bani Mattar.',
                    'it' => 'Antica eredità del caffè dalle terrazze di Haraz e Bani Mattar.',
                    'nl' => 'Oud koffie-erfgoed van de terrassen van Haraz en Bani Mattar.',
                    'tr' => 'Haraz ve Bani Mattar yamaçlarından gelen kadim kahve mirası.'
                ],
                'image' => 'categories/coffee.png'
            ],
            [
                'name' => [
                    'en' => 'Luxury Textiles', 
                    'ar' => 'منسوجات فاخرة', 
                    'fr' => 'Textiles de Luxe',
                    'de' => 'Luxus-Textilien',
                    'es' => 'Textiles de Lujo',
                    'it' => 'Tessuti di Lusso',
                    'nl' => 'Luxe Textiel',
                    'tr' => 'Lüks Tekstil'
                ],
                'slug' => 'luxury-textiles',
                'description' => [
                    'en' => 'Handwoven silks and traditional Mawiz steeped in century-old tradition.',
                    'ar' => 'منسوجات حريرية يدوية ومعاوز تقليدية عريقة.',
                    'fr' => 'Soies tissées à la main et Mawiz traditionnels imprégnés de traditions séculaires.',
                    'de' => 'Handgewebte Seiden und traditionelle Mawiz mit jahrhundertealter Tradition.',
                    'es' => 'Sedas tejidas a mano y Mawiz tradicionales con siglos de tradición.',
                    'it' => 'Sete tessute a mano e Mawiz tradizionali intrisi di una tradizione secolare.',
                    'nl' => 'Handgeweven zijde en traditionele Mawiz dorenvlochten met eeuwenoude tradities.',
                    'tr' => 'Asırlık geleneğe sahip el dokuması ipekler ve geleneksel Mawizler.'
                ],
                'image' => 'categories/silk.png'
            ],
            [
                'name' => [
                    'en' => 'Artisan Jewelry', 
                    'ar' => 'مجوهرات حرفية', 
                    'fr' => 'Bijoux Artisanaux',
                    'de' => 'Kunsthandwerklicher Schmuck',
                    'es' => 'Joyas Artesanales',
                    'it' => 'Gioielli Artigianali',
                    'nl' => 'Ambachtelijke Sieraden',
                    'tr' => 'Zanaatkâr Mücevheratı'
                ],
                'slug' => 'artisan-jewelry',
                'description' => [
                    'en' => 'Traditional Yemeni silver and gemstones crafted by master silversmiths.',
                    'ar' => 'فضة يمنية تقليدية وأحجار كريمة صاغها كبار الحرفيين.',
                    'fr' => 'Argent yéménite traditionnel et pierres précieuses façonnés par des maîtres orfèvres.',
                    'de' => 'Traditionelles jemenitisches Silber und Edelsteine, gefertigt von Meister-Silberschmieden.',
                    'es' => 'Plata y gemas tradicionales yemeníes elaboradas por maestros plateros.',
                    'it' => 'Argento e pietre preziose tradizionali yemeniti creati da maestri argentieri.',
                    'nl' => 'Traditioneel Jemenitisch zilver en edelstenen vervaardigd door meester-zilversmeden.',
                    'tr' => 'Usta gümüşçüler tarafından işlenmiş geleneksel Yemen gümüşü ve değerli taşları.'
                ],
                'image' => 'categories/jewelry.png'
            ],
            [
                'name' => [
                    'en' => 'Royal Spices', 
                    'ar' => 'بهارات ملكية', 
                    'fr' => 'Épices Royales',
                    'de' => 'Königliche Gewürze',
                    'es' => 'Especias Reales',
                    'it' => 'Spezie Reali',
                    'nl' => 'Koninklijke Specerijen',
                    'tr' => 'Kraliyet Baharatları'
                ],
                'slug' => 'royal-spices',
                'description' => [
                    'en' => 'Exotic blends and rare saffron from the legendary spice routes.',
                    'ar' => 'خلطات فريدة وزعفران نادر من طرق التوابل الأسطورية.',
                    'fr' => 'Mélanges exotiques et safran rare issus des légendaires routes des épices.',
                    'de' => 'Exotische Mischungen und seltener Safran von den legendären Gewürzstraßen.',
                    'es' => 'Mezclas exóticas y azafrán raro de las legendarias rutas de las especias.',
                    'it' => 'Miscele esotiche e zafferano raro dalle leggendarie rotte delle spezie.',
                    'nl' => 'Exotische melanges en zeldzame saffraan van de legendarische specerijenroutes.',
                    'tr' => 'Efsanevi baharat yollarından gelen egzotik karışımlar ve nadir safran.'
                ],
                'image' => 'categories/spices.png'
            ],
        ];

        foreach ($categories as $catData) {
            $category = Category::create([
                'name' => $catData['name'],
                'slug' => $catData['slug'],
                'description' => $catData['description'],
                'image' => $catData['image'],
                'is_active' => true,
                'is_featured' => true,
            ]);

            // Add products for each category
            $this->createProductsForCategory($category);
        }

        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
    }

    private function createProductsForCategory($category)
    {
        $products = [
            'sidr-honey' => [
                [
                    'name' => [
                        'en' => 'Royal Sidr Honey (Malaki)', 
                        'ar' => 'عسل سدر ملكي فاخر', 
                        'fr' => 'Miel de Sidr Royal',
                        'de' => 'Königlicher Sidr-Honig (Malaki)',
                        'es' => 'Miel de Sidr Real (Malaki)',
                        'it' => 'Miele di Sidr Reale (Malaki)',
                        'nl' => 'Koninklijke Sidr-honing (Malaki)',
                        'tr' => 'Kraliyet Sidr Balı (Malaki)'
                    ],
                    'price' => 120.00,
                    'description' => [
                        'en' => 'Rare Malaki grade honey from the valleys of Hadramout. Known for its medicinal properties and exquisite taste.',
                        'ar' => 'عسل ملكي نادر من وديان حضرموت، مشهور بخصائصه العلاجية وطعمه الاستثنائي.',
                        'fr' => 'Miel rare de qualité Malaki provenant des vallées du Hadramout. Connu pour ses propriétés médicinales.',
                        'de' => 'Seltener Malaki-Honig aus den Tälern von Hadramout. Bekannt für seine medizinischen Eigenschaften.',
                        'es' => 'Miel rara de grado Malaki de los valles de Hadramout. Conocida por sus propiedades medicinales.',
                        'it' => 'Miele raro di grado Malaki dalle valli di Hadramout. Noto per le sue proprietà medicinali.',
                        'nl' => 'Zeldzame Malaki-honing uit de valleien van Hadramout. Bekend om zijn medicinale eigenschappen.',
                        'tr' => 'Hadramut vadilerinden elde edilen nadir Malaki sınıfı bal. Tıbbi özellikleri ve enfes tadıyla bilinir.'
                    ],
                    'material' => [
                        'en' => '100% Pure Natural Honey',
                        'ar' => 'عسل طبيعي نقي 100%',
                        'fr' => '100% Miel Naturel Pur',
                        'de' => '100% reiner Naturhonig',
                        'es' => '100% Miel Natural Pura',
                        'it' => '100% Miele Naturale Puro',
                        'nl' => '100% pure natuurlijke honing',
                        'tr' => '%100 Saf Doğal Bal'
                    ],
                    'care_instructions' => [
                        'en' => 'Store at room temperature. Do not refrigerate.',
                        'ar' => 'يُحفظ في درجة حرارة الغرفة. لا يوضع في الثلاجة.',
                        'fr' => 'Conserver à température ambiante. Ne pas réfrigérer.',
                        'de' => 'Bei Raumtemperatur lagern. Nicht im Kühlschrank aufbewahren.',
                        'es' => 'Almacenar a temperatura ambiente. No refrigerar.',
                        'it' => 'Conservare a temperatura ambiente. Non refrigerare.',
                        'nl' => 'Op kamertemperatuur bewaren. Niet in de koelkast bewaren.',
                        'tr' => 'Oda sıcaklığında saklayın. Buzdolabına koymayın.'
                    ],
                ],
                [
                    'name' => [
                        'en' => 'Wild Cave Honey', 
                        'ar' => 'عسل الكهوف البري', 
                        'fr' => 'Miel de Grotte Sauvage',
                        'de' => 'Wilder Höhlenhonig',
                        'es' => 'Miel de Cueva Silvestre',
                        'it' => 'Miele di Grotta Selvatico',
                        'nl' => 'Wilde Grothoning',
                        'tr' => 'Yabani Mağara Balı'
                    ],
                    'price' => 180.00,
                    'description' => [
                        'en' => 'Dark, thick, and potent honey harvested from wild bees living in ancient caves.',
                        'ar' => 'عسل داكن وكثيف وقوي، يتم جمعه من النحل البري الذي يعيش في الكهوف القديمة.',
                        'fr' => 'Miel sombre, épais et puissant récolté auprès d\'abeilles sauvages vivant dans des grottes anciennes.',
                        'de' => 'Dunkler, dicker und kräftiger Honig, geerntet von wilden Bienen aus alten Höhlen.',
                        'es' => 'Miel oscura, espesa y potente cosechada de abejas silvestres que viven en cuevas antiguas.',
                        'it' => 'Miele scuro, denso e potente raccolto da api selvatiche che vivono in antiche grotte.',
                        'nl' => 'Donkere, dikke en krachtige honing geoogst van wilde bijen die in oude grotten leven.',
                        'tr' => 'Antik mağaralarda yaşayan yabani arılardan hasat edilen koyu, kıvamlı ve güçlü bal.'
                    ],
                ]
            ],
            'mocha-coffee' => [
                [
                    'name' => [
                        'en' => 'Mocha Peaberry Gold', 
                        'ar' => 'بن موكا لؤلؤي ذهبي', 
                        'fr' => 'Café Mocha Peaberry',
                        'de' => 'Mocha Peaberry Gold',
                        'es' => 'Mocha Peaberry Oro',
                        'it' => 'Mocha Peaberry Gold',
                        'nl' => 'Mocha Peaberry Goud',
                        'tr' => 'Mocha Peaberry Altın'
                    ],
                    'price' => 45.00,
                    'description' => [
                        'en' => 'Rare peaberry beans with notes of dark chocolate and dried fruits.',
                        'ar' => 'حبوب البن اللؤلؤية النادرة مع نكهات الشوكولاتة الداكنة والفواكه المجففة.',
                        'fr' => 'Grains de café peaberry rares avec des notes de chocolat noir et de fruits secs.',
                        'de' => 'Seltene Peaberry-Bohnen mit Noten von dunkler Schokolade und Trockenfrüchten.',
                        'es' => 'Granos de café peaberry raros con notas de chocolate negro y frutas secas.',
                        'it' => 'Rari chicchi di caffè peaberry con note di cioccolato fondente e frutta secca.',
                        'nl' => 'Zeldzame peaberry-bonen met tonen van pure chocolade en gedroogd fruit.',
                        'tr' => 'Bitter çikolata ve kuru meyve notalarına sahip nadir peaberry çekirdekleri.'
                    ],
                ],
                [
                    'name' => [
                        'en' => 'Ancient Harazi Blend', 
                        'ar' => 'مزيج حرازي عتيق', 
                        'fr' => 'Mélange Harazi Ancien',
                        'de' => 'Alte Harazi-Mischung',
                        'es' => 'Mezcla Harazi Antigua',
                        'it' => 'Miscela Harazi Antica',
                        'nl' => 'Oude Harazi-blend',
                        'tr' => 'Kadim Harazi Karışımı'
                    ],
                    'price' => 38.00,
                    'description' => [
                        'en' => 'Organically grown coffee from the high-altitude terraces of Haraz.',
                        'ar' => 'قهوة مزروعة عضويًا من المدرجات الجبلية العالية في منطقة حراز.',
                        'fr' => 'Café de culture biologique provenant des hautes terrasses de Haraz.',
                        'de' => 'Biologisch angebauter Kaffee von den Hochterrassen von Haraz.',
                        'es' => 'Café de cultivo orgánico de las terrazas de gran altitud de Haraz.',
                        'it' => 'Caffè biologico dalle terrazze ad alta quota di Haraz.',
                        'nl' => 'Biologisch geteelde koffie van de hooggelegen terrassen van Haraz.',
                        'tr' => 'Haraz\'ın yüksek rakımlı teraslarından geleneksel olarak yetiştirilen kahve.'
                    ],
                ]
            ],
            'luxury-textiles' => [
                [
                    'name' => [
                        'en' => 'Royal Silk Mawiz', 
                        'ar' => 'معوز حرير ملكي', 
                        'fr' => 'Mawiz en Soie Royale',
                        'de' => 'Königliche Seide Mawiz',
                        'es' => 'Mawiz de Seda Real',
                        'it' => 'Mawiz in Seta Reale',
                        'nl' => 'Koninklijke Zijden Mawiz',
                        'tr' => 'Kraliyet İpeği Mawiz'
                    ],
                    'price' => 250.00,
                    'description' => [
                        'en' => 'Traditional handwoven garment made from the finest Yemeni silk with gold embroidery.',
                        'ar' => 'ثوب تقليدي منسوج يدويًا من أفضل أنواع الحرير اليمني مع تطريز ذهبي.',
                        'fr' => 'Vêtement traditionnel tissé à la main, fabriqué à partir de la soie la plus fine avec des broderies d\'or.',
                        'de' => 'Traditionelles handgewebtes Gewand aus feinster jemenitischer Seide mit Goldstickerei.',
                        'es' => 'Prenda tradicional tejida a mano con la mejor seda yemení y bordado en oro.',
                        'it' => 'Capo tradizionale tessuto a mano nella migliore seta yemenita con ricami in oro.',
                        'nl' => 'Traditioneel handgeweven kledingstuk gemaakt van de fijnste Jemenitische zijde met goudborduursel.',
                        'tr' => 'En kaliteli Yemen ipeğinden üretilmiş, altın işlemeli geleneksel el dokuması giysi.'
                    ],
                    'material' => [
                        'en' => 'Natural Silk, Gold Threads',
                        'ar' => 'حرير طبيعي، خيوط ذهبية',
                        'fr' => 'Soie naturelle, fils d\'or',
                        'de' => 'Naturseide, Goldfäden',
                        'es' => 'Seda natural, hilos de oro',
                        'it' => 'Seta naturale, fili d\'oro',
                        'nl' => 'Natuurlijke zijde, gouddraden',
                        'tr' => 'Doğal İpek, Altın İplikler'
                    ],
                    'care_instructions' => [
                        'en' => 'Dry clean only. Handle with care.',
                        'ar' => 'تنظيف جاف فقط. تعامل بعناية.',
                        'fr' => 'Nettoyage à sec uniquement. Manipuler avec soin.',
                        'de' => 'Nur chemische Reinigung. Mit Vorsicht behandeln.',
                        'es' => 'Solo limpieza en seco. Manejar con cuidado.',
                        'it' => 'Solo lavaggio a secco. Maneggiare con cura.',
                        'nl' => 'Alleen chemisch reinigen. Voorzichtig behandelen.',
                        'tr' => 'Sadece kuru temizleme. Dikkatli tutun.'
                    ],
                ],
                [
                    'name' => [
                        'en' => 'Ancestral Pashmina Shala', 
                        'ar' => 'شال كشميري يمني عتيق', 
                        'fr' => 'Châle Pashmina Ancestral',
                        'de' => 'Ahnen-Pashmina Shala',
                        'es' => 'Chal Pashmina Ancestral',
                        'it' => 'Sciarpa Pashmina Ancestrale',
                        'nl' => 'Voorouderlijke Pashmina Shala',
                        'tr' => 'Atalardan Kalma Paşmina Şal'
                    ],
                    'price' => 150.00,
                    'description' => [
                        'en' => 'Exquisite shawl woven with intricate patterns dating back to the Sabian era.',
                        'ar' => 'شال رائع منسوج بأنماط معقدة تعود إلى العصر السبئي.',
                        'fr' => 'Châle exquis tissé avec des motifs complexes datant de l\'ère Sabéenne.',
                        'de' => 'Exquisiter Schal, gewebt mit komplizierten Mustern aus der sabäischen Ära.',
                        'es' => 'Exquisito chal tejido con patrones intrincados que datan de la era Sabea.',
                        'it' => 'Sciarpa squisita tessuta con motivi intricati risalenti all\'era sabea.',
                        'nl' => 'Prachtige sjaal geweven met ingewikkelde patronen uit het Sabeïsche tijdperk.',
                        'tr' => 'Sebe dönemine dayanan karmaşık desenlerle dokunmuş enfes şal.'
                    ],
                ]
            ],
            'artisan-jewelry' => [
                [
                    'name' => [
                        'en' => 'Silver Filigree Jambiya', 
                        'ar' => 'جنبية فضة يدوية', 
                        'fr' => 'Jambiya en Filigrane d\'Argent',
                        'de' => 'Silberne Filigran-Jambiya',
                        'es' => 'Jambiya de Filigrana de Plata',
                        'it' => 'Jambiya in Filigrana d\'Argento',
                        'nl' => 'Zilveren Filigraan Jambiya',
                        'tr' => 'Gümüş Telkari Jambiya'
                    ],
                    'price' => 450.00,
                    'description' => [
                        'en' => 'Iconic Yemeni dagger with a handle and sheath crafted in pure sterling silver filigree.',
                        'ar' => 'الخنجر اليمني الشهير بمقبض وغمد مصنوع من الفضة الإسترلينية الخالصة.',
                        'fr' => 'Dague yéménite emblématique avec une poignée et un fourreau artisanaux en argent massif.',
                        'de' => 'Ikonischer jemenitischer Dolch mit Griff und Scheide aus reinem Sterlingsilber-Filigran.',
                        'es' => 'Daga yemení icónica con mango y vaina elaborados en filigrana de plata de ley pura.',
                        'it' => 'Iconica daga yemenita con manico e fodero realizzati in pura filigrana d\'argento sterling.',
                        'nl' => 'Iconische Jemenitische dolk met een handvat en schede vervaardigd in puur zilverfiligraan.',
                        'tr' => 'Tamamen saf gümüş telkari ile işlenmiş kabza ve kınıyla ikonik Yemen hançeri.'
                    ],
                ],
                [
                    'name' => [
                        'en' => 'Red Coral & Amber Necklace', 
                        'ar' => 'عقد مرجان وكهرمان يمني', 
                        'fr' => 'Collier de Corail Rouge et Ambre',
                        'de' => 'Halskette aus roter Koralle und Bernstein',
                        'es' => 'Collar de Coral Rojo y Ámbar',
                        'it' => 'Collana di Corallo Rosso e Ambra',
                        'nl' => 'Ketting met Rood Koraal en Barnsteen',
                        'tr' => 'Kırmızı Mercan ve Kehribar Kolye'
                    ],
                    'price' => 320.00,
                    'description' => [
                        'en' => 'Stunning traditional necklace featuring hand-carved coral and aged amber beads.',
                        'ar' => 'عقد تقليدي مذهل يتميز بخرز المرجان المنحوت يدويًا والعنبر العتيق.',
                        'fr' => 'Superbe collier traditionnel avec du corail sculpté à la main et de l\'ambre vieilli.',
                        'de' => 'Atemberaubende traditionelle Halskette mit handgeschnitzten Korallen- und Bernsteinperlen.',
                        'es' => 'Impresionante collar tradicional con perlas de coral talladas a mano y ámbar envejecido.',
                        'it' => 'Splendida collana tradizionale con corallo intagliato a mano e perline di ambra invecchiata.',
                        'nl' => 'Prachtige traditionele ketting met handgesneden koraal en gerijpte barnstenen kralen.',
                        'tr' => 'Elde oyulmuş mercan ve yaşlandırılmış kehribar boncuklardan oluşan çarpıcı geleneksel kolye.'
                    ],
                ]
            ],
            'royal-spices' => [
                [
                    'name' => [
                        'en' => 'Saffron Supreme (Hadramout)', 
                        'ar' => 'زعفران السعادة الفاخر', 
                        'fr' => 'Safran Suprême',
                        'de' => 'Safran Supreme (Hadramout)',
                        'es' => 'Azafrán Supremo (Hadramout)',
                        'it' => 'Zafferano Supreme (Hadramout)',
                        'nl' => 'Saffraan Supreme (Hadramout)',
                        'tr' => 'Saffron Supreme (Hadramut)'
                    ],
                    'price' => 85.00,
                    'description' => [
                        'en' => 'Hand-picked saffron threads of the highest grade, known for intense color and aroma.',
                        'ar' => 'خيوط الزعفران المختارة يدويًا من أعلى الدرجات، المعروفة بلونها ورائحتها المكثفة.',
                        'fr' => 'Pistils de safran cueillis à la main de la plus haute qualité.',
                        'de' => 'Handverlesene Safranfäden höchster Güte, bekannt für intensive Farbe und Aroma.',
                        'es' => 'Hilos de azafrán seleccionados a mano de la más alta calidad.',
                        'it' => 'Zafferano in pistilli raccolto a mano di altissima qualità.',
                        'nl' => 'Handgeplukte saffraandraadjes van de hoogste kwaliteit.',
                        'tr' => 'Yoğun rengi ve aromasıyla tanınan, en yüksek kalitede elle toplanmış safran telleri.'
                    ],
                ],
                [
                    'name' => [
                        'en' => 'Legendary Hawayej Spirit', 
                        'ar' => 'حوايج يمنية ملكية', 
                        'fr' => 'Esprit d\'Hawayej Légendaire',
                        'de' => 'Legendärer Hawayej-Geist',
                        'es' => 'Espíritu de Hawayej Legendario',
                        'it' => 'Spirito di Hawayej Leggendario',
                        'nl' => 'Legendarische Hawayej-geest',
                        'tr' => 'Efsanevi Havayic Ruhu'
                    ],
                    'price' => 25.00,
                    'description' => [
                        'en' => 'A master blend of ancient spices including ginger, cardamom, and clove.',
                        'ar' => 'مزيج متقن من التوابل القديمة بما في ذلك الزنجبيل والهيل والقرنفل.',
                        'fr' => 'Un mélange de maître d\'épices anciennes comprenant du gingembre, de la cardamome et du clou de girofle.',
                        'de' => 'Eine Meistermischung aus alten Gewürzen wie Ingwer, Kardamom und Nelken.',
                        'es' => 'Una mezcla maestra de especias antiguas que incluye jengibre, cardamomo y clavo.',
                        'it' => 'Una miscela magistrale di spezie antiche tra cui zenzero, cardamomo e chiodi di garofano.',
                        'nl' => 'Een meesterlijke mix van eeuwenoude specerijen, waaronder gember, kardemom en kruidnagel.',
                        'tr' => 'Zencefil, kakule ve karanfil dahil olmak üzere antik baharatların ustaca bir karışımı.'
                    ],
                ]
            ]
        ];

        $categoryProducts = $products[$category->slug] ?? [];

        foreach ($categoryProducts as $pData) {
            Product::create([
                'category_id' => $category->id,
                'name' => $pData['name'],
                'slug' => Str::slug($pData['name']['en']),
                'base_price' => $pData['price'],
                'description' => $pData['description'],
                'sku' => strtoupper(Str::random(10)),
                'stock' => rand(5, 50),
                'is_active' => true,
                'is_featured' => true,
                'images' => ['products/' . $category->slug . '-1.jpg'],
                'material' => $pData['material'] ?? null,
                'care_instructions' => $pData['care_instructions'] ?? null,
            ]);
        }
    }
}
