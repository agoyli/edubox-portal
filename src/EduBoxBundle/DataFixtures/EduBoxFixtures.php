<?php


namespace EduBoxBundle\DataFixtures;


use Application\Sonata\ClassificationBundle\Entity\Category;
use Application\Sonata\ClassificationBundle\Entity\Context;
use Application\Sonata\ClassificationBundle\Entity\Tag;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use EduBoxBundle\Entity\Author;
use EduBoxBundle\Entity\Book;
use EduBoxBundle\Entity\Problem;
use EduBoxBundle\Entity\ProblemTest;
use EduBoxBundle\Entity\Resource;
use EduBoxBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class EduBoxFixtures extends Fixture
{
    public $kernelRootDir;

    public function load(ObjectManager $manager)
    {

        // Contexts
        $contexts = [
            "default" => [
                "name" => "Default",
            ],
            "book" => [
                "name" => "Kitap",
            ],
            "problem" => [
                "name" => "Mesele",
            ],
            "resource" => [
                "name" => "Maglumat",
            ],
            "author" => [
                "name" => "Awtor",
            ]
        ];
        foreach ($contexts as $key => $item)
        {
            $context = new Context();
            $context->setEnabled(true);
            $context->setId($key);
            $context->setName($item["name"]);
            $manager->persist($context);
            $contexts[$key]["context"] = $context;
        }
        $manager->flush();


        // Categories
        $categories = [
            // book
            "adventure" => [
                "name" => "Başdan geçirme",
                "context" => $contexts["book"],
            ],
            "classic" => [
                "name" => "Klassik",
                "context" => $contexts["book"],
            ],
            "crime-detective" => [
                "name" => "Jenaýat we sülçi",
                "context" => $contexts["book"],
            ],
            "drama" => [
                "name" => "Drama",
                "context" => $contexts["book"],
            ],
            "fable" => [
                "name" => "Basnýa",
                "context" => $contexts["book"],
            ],
            "fairy-tale" => [
                "name" => "Erteki",
                "context" => $contexts["book"],
            ],
            "fantasy" => [
                "name" => "Fantaziýa",
                "context" => $contexts["book"],
            ],
            "humor" => [
                "name" => "Komediýa",
                "context" => $contexts["book"],
            ],
            "biography" => [
                "name" => "Terjimehal",
                "context" => $contexts["book"],
            ],
            "memoir" => [
                "name" => "Ylmy makala",
                "context" => $contexts["book"],
            ],
            "reference" => [
                "name" => "Gollanma",
                "context" => $contexts["book"],
            ],
            "schoolbook" => [
                "name" => "Mekdep kitaby",
                "context" => $contexts["book"],
            ],
            // Resources
            "turkmen" => [
                "name" => "Türkmen dili",
                "context" => $contexts["resource"],
            ],
            "literature" => [
                "name" => "Edebiýat",
                "context" => $contexts["resource"],
            ],
            "computer-science" => [
                "name" => "Informatika",
                "context" => $contexts["resource"],
            ],
            "english" => [
                "name" => "Iňlis dili",
                "context" => $contexts["resource"],
            ],
            "math" => [
                "name" => "Matematika",
                "context" => $contexts["resource"],
            ],
            // Problems
            "for-beginners" => [
                "name" => "Başlangyçlar üçin",
                "context" => $contexts["problem"],
            ],
            "logic-expressions" => [
                "name" => "Logiki aňlatmalar",
                "context" => $contexts["problem"],
            ],
            "integer-arithmetic" => [
                "name" => "Bitin sanlar",
                "context" => $contexts["problem"],
            ],
            "conditional-operator" => [
                "name" => "Şertli operator",
                "context" => $contexts["problem"],
            ],
            "dynamic-programming" => [
                "name" => "Dinamik programmirleme",
                "context" => $contexts["problem"],
            ],
            // Author
            "writer" => [
                "name" => "Şahyr",
                "context" => $contexts["author"],
            ],
            "scientist" => [
                "name" => "Alym",
                "context" => $contexts["author"],
            ],
        ];
        // Creating categories
        // Create parent categories
        try {
            foreach ($contexts as $key => $item) {
                $category = new Category();
                $category->setEnabled(true);
                $category->setName($item["name"]);
                $category->setContext($item["context"]);
                $category->setSlug($key);
                $manager->persist($category);
                if (isset($categories[$key])) throw new \Exception('Category with "'.$key.'" slug already exists.');
                $contexts[$key]["context"]->category = $category;
            }
        }
        catch (\Exception $exception) {
            echo $exception->getMessage();
            exit();
        }
        // Create child categories
        foreach ($categories as $key => $item) {
            $category = new Category();
            $category->setEnabled(true);
            $category->setName($item["name"]);
            $category->setContext($item["context"]["context"]);
            $category->setSlug($key);
            $category->setParent($item["context"]["context"]->category);
            $manager->persist($category);
        }
        $manager->flush();


        // Tags
        $tags = [
            // book
            // resources
            // problems
            "olympiad" => [
                "name" => "Olimpiýada",
                "context" => $contexts["problem"],
            ],
            "olympiad-2018" => [
                "name" => "Olimpiýada 2018",
                "context" => $contexts["problem"],
            ],
            "olympiad-2019" => [
                "name" => "Olimpiýada 2019",
                "context" => $contexts["problem"],
            ],
            "olympiad-11" => [
                "name" => "Olimpiýada 11 synp",
                "context" => $contexts["problem"],
            ],
            "olympiad-10" => [
                "name" => "Olimpiýada 10 synp",
                "context" => $contexts["problem"],
            ],
            "olympiad-9" => [
                "name" => "Olimpiýada 9 synp",
                "context" => $contexts["problem"],
            ],
            "geometry" => [
                "name" => "Geometriýa",
                "context" => $contexts["problem"],
            ],
            "two-d-arrays" => [
                "name" => "Ikili massiwler",
                "context" => $contexts["problem"],
            ],
            "combinatorics" => [
                "name" => "Kombinasiýa",
                "context" => $contexts["problem"],
            ],
            "string" => [
                "name" => "Setirler",
                "context" => $contexts["problem"],
            ],
            "recursion" => [
                "name" => "Rekursiýa",
                "context" => $contexts["problem"],
            ],
            "sorting" => [
                "name" => "Tertiplemek",
                "context" => $contexts["problem"],
            ],
            "graph-theory" => [
                "name" => "Graflar teoriýasy",
                "context" => $contexts["problem"],
            ],

        ];
        foreach ($tags as $key => $item) {
            $category = new Tag();
            $category->setEnabled(true);
            $category->setName($item["name"]);
            $category->setContext($item["context"]["context"]);
            $category->setSlug($key);
            $manager->persist($category);
        }
        $manager->flush();


        // Users
        $users = [
            "admin" => [
                "password" => "admin",
                "roles" => ["ROLE_SUPER_ADMIN"],
            ],
            "user" => [
                "password" => "user",
                "roles" => [],
            ],
        ];
        foreach ($users as $key => $item) {
            $user = new User();
            $user->setEnabled(true);
            $user->setUsername($key);
            $user->setRoles($item["roles"]);
            $user->setPlainPassword($item["password"]);
            $user->setEmail($key."@site.com");
            $manager->persist($user);
        }
        $manager->flush();


        // Authors
        $authors = [
            "1" => ["fullname" => "Gurbannazar Ezizow"],
            "3" => [
                "fullname" => "Nurmyrat Saryhanow",
                "image" => "uploads/image/author/3.jpg",
                "content" => "1906-njy ýylda Gökdepe etrabynyň ikinji Gökdepe obasynda garyp daýhan maşgalasynda eneden dogulýar. Ol ilki oba mekdebinde okaýar. 1925-nji ýylda onuň kakasy Aşgabat etrabynyň Gökje obasyna göçüp gelýär. Ýaşlykda okamaga bolan höwes ony Aşgabatdaky politehnikuma alyp gelýär. Tehnikumda Nurmyrat üstünlik bilen okaýar hem şonuň bilen bir wagtda “Türkmenistan” gazetiniň redaksiýasynda işleýär. 1928-nji ýylda Nurmyrat Saryhanow Daşkende okuwa gidýär. Ol ýerde žurnalistleriň bir ýyllyk kursyny gutarýar. Ol 1929-njy ýyldan tä 1937-nji ýyla çenli Goşun hatarynda gulluk edýär. Bu ýyllar Nurmyrat uly terbiýeçilik mekdebini geçýär. Onuň syýasy taýýarlygy ösýär. Bilim derejesi artýar. Köpçülik işlerine işjeň gatnaşýar. “Gyzyl goşun” atly harby gazetiň jogapkär sekretary bolup işleýär. N.Saryhanow 1937-41-nji ýyllarda dürli gazetleriň redaksiýalarynda, “Sowet edebiýaty”, “Garagum” žurnalynda işleýär. Metbugat işi bilen aragatnaşyk saklamagy ony edebiýat meýdanyna çykarýar. N.Saryhanow zähmetsöýer, joşgunly watançydyr. Beýik Watançylyk Urşy başlanan wagtynda ol meýletinlik bilen Watan goragyna gidip, özüniň ýiti galamy, ötgür ýaragy bilen faşistlara garşy batyrgaý söweşýär. 1944-nji ýylyň maý aýynyň 4-ne Gitlere garşy söweş meýdanynda gahrymanlarça wepat bolýar.<br>N.Saryhanow türkmen prozasynyň taryhyna “Şirin”, “Kitap”, “Arzuw”, “Soňky öý”, “Ak tam”, “Giýew” ýaly hekaýalary, “Şükür bagşy”, “Ýagtylyga çykanlar”, “Gyzgyn günler” ýaly powesleriň \"Hossarlygy”, “Aýjemal”, “Garaş aga”, “Ene” ýaly oçerklerini goşmak bilen özüne müdümi ýadygärlik galdyrdy. Olar çuň ideýaly, joşgunly watançylyk, dostluk, gumanistik, internalistik ideýalary duýgulara ýugrulan eserlerdir.<br>N.Saryhanowyň eserleri türkmen dilinde we goňşy halklaryň birnäçesiniň dilinde ençeme gezek neşir edildi we edilýär.<br>",
            ],
            "4" => ["fullname" => "Kerim Gurbannepesow"],
            "8" => ["fullname" => "Gurbanaly Magrupy"],
            "2" => ["fullname" => "Çary Aşyrow"],
            "5" => ["fullname" => "Baýmuhammet Garryýew"],
            "6" => ["fullname" => "Mämmet Seýidow"],
            "7" => ["fullname" => "Hydyr Derýaýew"],
            "9" => ["fullname" => "Ata Gowşudow"],
            "10" => ["fullname" => "Şamyrat Taganow"],
            "11" => ["fullname" => "Abulgaz Bahadur"],
            "12" => ["fullname" => "Şamyrat Tagan"],
            "13" => ["fullname" => "Arap Gurbanow"],
            "14" => ["fullname" => "Ata Atajanow"],
            "15" => ["fullname" => "Atajan Tagan"],
            "16" => ["fullname" => "Seýitmyrat Öwezbaýew"],
            "17" => ["fullname" => "Halk Döredijiligi"],
            "18" => ["fullname" => "Rahym Esenow"],
            "19" => ["fullname" => "Mollanepes "],
            "20" => ["fullname" => "Annagylyç Mätäji"],
            "21" => ["fullname" => "Mämmetweli Kemine"],
            "22" => ["fullname" => "Magtymguly Pyragy"],
            "23" => ["fullname" => "Aşyr Hanow"],
            "24" => ["fullname" => "Nobatguly Rejebow"],
            "25" => ["fullname" => "Berdi Kerbabaýew"],
            "26" => ["fullname" => "Aşyrgylyç Ýazgylyjow"],
            "27" => ["fullname" => "Andalyp Nurmuhammet"],
            "28" => ["fullname" => "Amangeldi Ylýas"],
            "29" => ["fullname" => "janabaý Şyhyýew"],
            "30" => ["fullname" => "Kakajan Ataýew"],
            "31" => ["fullname" => "B. Basarow"],
            "32" => ["fullname" => "T. Çaryýewa"],
            "33" => ["fullname" => "O. Nurgeldiýew"],
            "34" => ["fullname" => "M. Gurbanow"],
            "35" => ["fullname" => "J. Myradow"],
            "36" => ["fullname" => "A. Garajaýewa"],
            "37" => ["fullname" => "K. Garrybaýew"],
            "38" => ["fullname" => "H. Baýramgeldiýewa"],
            "39" => ["fullname" => "Ogulbaýram Şyhyýewa"],
            "40" => ["fullname" => "H. Baýramgeldiýewa"],
            "41" => ["fullname" => "A. Baýramowa"],
            "42" => ["fullname" => "O. Nurgeldiýew"],
            "43" => ["fullname" => "M. Hajyýew"],
            "44" => ["fullname" => "A. Garajaýewa"],
            "45" => ["fullname" => "Amangeldi Hydyr"],
            "46" => ["fullname" => "A. Esenow"],
            "47" => ["fullname" => "A. Ýagşymyradow"],
            "48" => ["fullname" => "J. Nuryýew"],
            "49" => ["fullname" => "A. Geldinazarowa"],
            "50" => ["fullname" => "Ç. Çoşşyýew"],
            "51" => ["fullname" => "N. Nurgeldiýew"],
            "52" => ["fullname" => "S. Seýitmyradow"],
            "53" => ["fullname" => "Çary Aýnazarow"],
            "54" => ["fullname" => "S. Aşyrow"],
            "55" => ["fullname" => "Gülşat Orazgeldiýewa"],
            "56" => ["fullname" => "P. Mustakow"],
            "57" => ["fullname" => "M. Gurbanow"],
            "58" => ["fullname" => "A. Kiçiýew"],
            "59" => ["fullname" => "H. Ahmetýanowa"],
            "60" => ["fullname" => "B. Babsarow"],
            "61" => ["fullname" => "R. Köçäýewa"],
            "62" => ["fullname" => "Şöhrat Abdyýew"],
            "63" => ["fullname" => "K. Kerwenowa"],
            "64" => ["fullname" => "A. Kliçowa"],
            "65" => ["fullname" => "B. Atajanow"],
            "66" => ["fullname" => "G. Orazow"],
            "67" => ["fullname" => "B. Muhammedowa"],
            "68" => ["fullname" => "S. Seýitgeldiýew"],
            "69" => ["fullname" => "G. Orazow"],
            "70" => ["fullname" => "T. Taýjanow"],
            "71" => ["fullname" => "K. Garrybaýew"],
            "72" => ["fullname" => "N. Nurgeldiýew"],
            "73" => ["fullname" => "A. Suhanow"],
            "74" => ["fullname" => "Ogulsenem Taňňyýewa"],
            "75" => ["fullname" => "A. Nuryýew"],
            "76" => ["fullname" => "Baýram Basarow"],
            "77" => ["fullname" => "K. Serdarow"],
            "78" => ["fullname" => "O. Sopyýewa"],
            "79" => ["fullname" => "O. Sopyýewa"],
            "80" => ["fullname" => "M. Döwletjanowa"],
            "81" => ["fullname" => "Ç. Durdyýew"],
            "82" => ["fullname" => "O. Mowlämowa"],
            "83" => ["fullname" => "K. Rowling"],
            "84" => ["fullname" => "arap erteki"],
            "85" => ["fullname" => "Öwez Gündogdyýew"],
            "86" => ["fullname" => "Jümmi Ataýew"],
            "87" => ["fullname" => "D. Gurbanow"],
            "88" => ["fullname" => "Elif Şafak"],
            "89" => ["fullname" => "A. Nuryýew"],
            "90" => ["fullname" => "B. Şapyýew"],
            "91" => ["fullname" => "M. Nyýazberdiýewa"],
            "92" => ["fullname" => "B. Pirjanow"],
            "93" => ["fullname" => "N. Nurgeldiýew"],
            "94" => ["fullname" => "H. Ahmetýarowa"],
            "95" => ["fullname" => "O. Berkeliýew"],
            "96" => ["fullname" => "M. Toýlyýew"],
            "97" => ["fullname" => "Gurbansähet Gurbansähedow"],
            "98" => ["fullname" => "G. Taýjanow"],
            "99" => ["fullname" => "Janabaý Şyhyýew"],
            "100" => ["fullname" => "O. Sopyýewa"],
            "101" => ["fullname" => "A. Esenowa"],
            "102" => ["fullname" => "Kakamyrat Ataýew"],
            "103" => ["fullname" => "S. Soltanmyradow"],
            "104" => ["fullname" => "B. Şapyýew"],
            "105" => ["fullname" => "D. Nurmuhammedow"],
            "106" => ["fullname" => "Ç. Durdyýew"],
            "107" => ["fullname" => "Aman Gurbangylyjow"],
            "108" => ["fullname" => "A. Jumahanow"],
            "109" => ["fullname" => "Abusagyt Abylhaýyr"],
            "110" => ["fullname" => "T. Taýjanow"],
            "111" => ["fullname" => "Nury Halmämmet"],
            "112" => ["fullname" => "N. Suhanow"],
            "113" => ["fullname" => "Agageldi Allnazarow"],
            "114" => ["fullname" => "H. Ahmetýarowa"],
            "115" => ["fullname" => "A. Çaryýewa"],
            "116" => ["fullname" => "O. Baýramow"],
            "117" => ["fullname" => "A. Allagulyýew"],
            "118" => ["fullname" => "Wasiliý Ýan"],
            "119" => ["fullname" => "S. Daňatarow"],
            "120" => ["fullname" => "M. Çaryýew"],
            "121" => ["fullname" => "Ç. Balgulyýew"],
            "122" => ["fullname" => "N. Annageldiýew"],
            "123" => ["fullname" => "T. Täjow"],
            "124" => ["fullname" => "H. Kurbanow"],
            "125" => ["fullname" => "Agageldi Allanazarow"],
            "126" => ["fullname" => "S. Babjanow"],
            "127" => ["fullname" => "P. Ýalpakow"],
            "128" => ["fullname" => "A. Geldiýew"],
            "129" => ["fullname" => "A. Gurbangylyjow"],
            "130" => ["fullname" => "A. Meredow"],
            "131" => ["fullname" => "E. Garajaýewa"],
            "132" => ["fullname" => "G. Orazow"],
            "133" => ["fullname" => "Jora Awliýakuliýew"],
            "134" => ["fullname" => "B. Çarygulyýew"],
            "135" => ["fullname" => "O. Möwlamowa"],
            "136" => ["fullname" => "Ýagşylyk Annamyradowa"],
            "137" => ["fullname" => "M. Resulgulyýew"],
            "138" => ["fullname" => "A. Ýagşymyradow"],
            "139" => ["fullname" => "O. Kubataýew"],
            "140" => ["fullname" => "A. Rejebow"],
            "141" => ["fullname" => "N. Rahmanow"],
            "142" => ["fullname" => "Çingiz Aýtmatow"],
            "143" => ["fullname" => "Gurbansähet Gurbansähedow"],
            "144" => ["fullname" => "D. Aşyrow"],
            "145" => ["fullname" => "N. Annaýew"],
            "146" => ["fullname" => "Fýodor Dostoýewskiý"],
            "147" => ["fullname" => "M. Gurbanow"],
            "148" => ["fullname" => "Ogulsenem Taňňyýewa"],
            "149" => ["fullname" => "Gurbannepes Jürdekow"],

        ];
        foreach ($authors as $key => $item) {
            $author = new Author();
            $author->setFullName($item['fullname']);
            $author->setId($key);
            if (isset($item['content'])) $author->setContent($item['content']);
            $manager->persist($author);
            if (isset($item['image']) && file_exists(realpath($this->kernelRootDir).'/web/'.$item['image'])) {
                $image = new Media();
                $image->setBinaryContent(realpath($this->kernelRootDir).'/web/'.$item['image']);
                $image->setContext('book');
                $image->setCategory($contexts['book']['context']->category);
                $image->setProviderName('sonata.media.provider.image');
                $author->setImage($image);
            }
            $authors[$key]["author"] = $author;
        }
        $manager->flush();


        // Books
        $books = [
            ["name" => "San bir söz diý…", "year" => "2012", "pages" => "75", "author" => "23", "bookfile" => "uploads/pdf/23.pdf", "bookImage" => "uploads/image/book/23.png"],
            ["name" => "Topragyň tagamy", "year" => "1979", "pages" => "92", "author" => "24", "bookfile" => "uploads/pdf/24.pdf", "bookImage" => "uploads/image/book/24.png"],
            ["name" => "Magrupy", "year" => "1991", "pages" => "48", "author" => "8", "bookfile" => "uploads/pdf/8.pdf", "bookImage" => "uploads/image/book/8.png"],
            ["name" => "Biçäreler", "year" => "2010", "pages" => "284", "author" => "146", "bookfile" => "uploads/pdf/147.pdf", "bookImage" => "uploads/image/book/147.png"],
            ["name" => "Şaýat bolmak aňsat däl", "year" => "2011", "pages" => "61", "author" => "148", "bookfile" => "uploads/pdf/149.pdf", "bookImage" => "uploads/image/book/149.png"],
            ["name" => "Ak gämi", "year" => "2010", "pages" => "81", "author" => "142", "bookfile" => "uploads/pdf/143.pdf", "bookImage" => "uploads/image/book/143.png"],
            ["name" => "Aziýanyň mawy alyslyklary", "year" => "2012", "pages" => "109", "author" => "118", "bookfile" => "uploads/pdf/119.pdf", "bookImage" => "uploads/image/book/119.png"],
            ["name" => "Yşk", "year" => "2010", "pages" => "651", "author" => "88", "bookfile" => "uploads/pdf/89.pdf", "bookImage" => "uploads/image/book/89.png"],
            ["name" => "Saýlanan eserler", "year" => "1995", "pages" => "262", "author" => "1", "bookfile" => "uploads/pdf/1.pdf", "bookImage" => "uploads/image/book/1.png"],
            ["name" => "Göreş", "year" => "1986", "pages" => "220", "author" => "2", "bookfile" => "uploads/pdf/2.pdf", "bookImage" => "uploads/image/book/2.png"],
            ["name" => "Şükür bagşy", "year" => "1961", "pages" => "53", "author" => "3", "bookfile" => "uploads/pdf/3.pdf", "bookImage" => "uploads/image/book/3.png"],
            ["name" => "Oýlanma baýry", "year" => "1995", "pages" => "437", "author" => "4", "bookfile" => "uploads/pdf/4.pdf", "bookImage" => "uploads/image/book/4.png"],
            ["name" => "Magtymguly", "year" => "1959", "pages" => "204", "author" => "5", "bookfile" => "uploads/pdf/5.pdf", "bookImage" => "uploads/image/book/5.png"],
            ["name" => "Kesearkaç", "year" => "", "pages" => "539", "author" => "6", "bookfile" => "uploads/pdf/6.pdf", "bookImage" => "uploads/image/book/6.png"],
            ["name" => "Ykbal birinji tom", "year" => "", "pages" => "325", "author" => "7", "bookfile" => "uploads/pdf/7.pdf", "bookImage" => "uploads/image/book/7.png"],
            ["name" => "Perman", "year" => "1989", "pages" => "993", "author" => "9", "bookfile" => "uploads/pdf/9.pdf", "bookImage" => "uploads/image/book/9.png"],
            ["name" => "Gara ýylgyn", "year" => "1989", "pages" => "174", "author" => "10", "bookfile" => "uploads/pdf/10.pdf", "bookImage" => "uploads/image/book/10.png"],
            ["name" => "Şejereýi Teräkime", "year" => "", "pages" => "48", "author" => "11", "bookfile" => "uploads/pdf/11.pdf", "bookImage" => "uploads/image/book/11.png"],
            ["name" => "Jüneýit han", "year" => "1992", "pages" => "30", "author" => "12", "bookfile" => "uploads/pdf/12.pdf", "bookImage" => "uploads/image/book/12.png"],
            ["name" => "Tanyş ýüzler", "year" => "1979", "pages" => "73", "author" => "13", "bookfile" => "uploads/pdf/13.pdf", "bookImage" => "uploads/image/book/13.png"],
            ["name" => "Teke gyzy Tatýana", "year" => "1997", "pages" => "193", "author" => "14", "bookfile" => "uploads/pdf/14.pdf", "bookImage" => "uploads/image/book/14.png"],
            ["name" => "Serwi gelin", "year" => "2014", "pages" => "498", "author" => "15", "bookfile" => "uploads/pdf/15.pdf", "bookImage" => "uploads/image/book/15.png"],
            ["name" => "Gönübek", "year" => "1991", "pages" => "38", "author" => "16", "bookfile" => "uploads/pdf/16.pdf", "bookImage" => "uploads/image/book/16.png"],
            ["name" => "Nejep oglan", "year" => "1997", "pages" => "65", "author" => "17", "bookfile" => "uploads/pdf/17.pdf", "bookImage" => "uploads/image/book/17.png"],
            ["name" => "Eziz han hakda hakykat", "year" => "1992", "pages" => "68", "author" => "18", "bookfile" => "uploads/pdf/18.pdf", "bookImage" => "uploads/image/book/18.png"],
            ["name" => "Mollanepes", "year" => "1991", "pages" => "55", "author" => "19", "bookfile" => "uploads/pdf/19.pdf", "bookImage" => "uploads/image/book/19.png"],
            ["name" => "Mätäji", "year" => "1991", "pages" => "52", "author" => "20", "bookfile" => "uploads/pdf/20.pdf", "bookImage" => "uploads/image/book/20.png"],
            ["name" => "Kemine", "year" => "1991", "pages" => "55", "author" => "21", "bookfile" => "uploads/pdf/21.pdf", "bookImage" => "uploads/image/book/21.png"],
            ["name" => "Magtymguly 2", "year" => "1991", "pages" => "54", "author" => "22", "bookfile" => "uploads/pdf/22.pdf", "bookImage" => "uploads/image/book/22.png"],
            ["name" => "Saýlananeserler", "year" => "1972", "pages" => "331", "author" => "25", "bookfile" => "uploads/pdf/25.pdf", "bookImage" => "uploads/image/book/25.png"],
            ["name" => "Maglumat tilsimatynyň serişdeleriniň seneli ösüşi", "year" => "2006", "pages" => "33", "author" => "26", "bookfile" => "uploads/pdf/26.pdf", "bookImage" => "uploads/image/book/26.png"],
            ["name" => "Ýusup-züleýha", "year" => "", "pages" => "116", "author" => "27", "bookfile" => "uploads/pdf/27.pdf", "bookImage" => "uploads/image/book/27.png"],
            ["name" => "Hekaýalar toplumy", "year" => "", "pages" => "41", "author" => "28", "bookfile" => "uploads/pdf/28.pdf", "bookImage" => "uploads/image/book/28.png"],
            ["name" => "Etnopsihologiýa", "year" => "2010", "pages" => "70", "author" => "29,30", "bookfile" => "uploads/pdf/29.pdf", "bookImage" => "uploads/image/book/29.png"],
            ["name" => "Aragatnaşygyň psihologiýasy", "year" => "2010", "pages" => "86", "author" => "31", "bookfile" => "uploads/pdf/30.pdf", "bookImage" => "uploads/image/book/30.png"],
            ["name" => "Metrologiýa we standartlaşdyrmak", "year" => "2010", "pages" => "73", "author" => "32", "bookfile" => "uploads/pdf/31.pdf", "bookImage" => "uploads/image/book/31.png"],
            ["name" => "Obýekte gönükdirilen programmirleme", "year" => "2010", "pages" => "124", "author" => "33", "bookfile" => "uploads/pdf/32.pdf", "bookImage" => "uploads/image/book/32.png"],
            ["name" => "Petrografiýa we petrologiýa", "year" => "2010", "pages" => "91", "author" => "34", "bookfile" => "uploads/pdf/33.pdf", "bookImage" => "uploads/image/book/33.png"],
            ["name" => "Leýli-Mejnun", "year" => "", "pages" => "72", "author" => "27", "bookfile" => "uploads/pdf/34.pdf", "bookImage" => "uploads/image/book/34.png"],
            ["name" => "Umumy we regional geotektonika", "year" => "2010", "pages" => "120", "author" => "35", "bookfile" => "uploads/pdf/35.pdf", "bookImage" => "uploads/image/book/35.png"],
            ["name" => "Nebit we gazyň tehnologiýasy", "year" => "2010", "pages" => "112", "author" => "36", "bookfile" => "uploads/pdf/36.pdf", "bookImage" => "uploads/image/book/36.png"],
            ["name" => "Önümçilikde metrologiýa gullugynyň gurnalyşy", "year" => "2010", "pages" => "82", "author" => "37", "bookfile" => "uploads/pdf/37.pdf", "bookImage" => "uploads/image/book/37.png"],
            ["name" => "Radioaktiw we elektrik däl usullar", "year" => "2010", "pages" => "92", "author" => "38", "bookfile" => "uploads/pdf/38.pdf", "bookImage" => "uploads/image/book/38.png"],
            ["name" => "Türkmen diliniň stilistikasy", "year" => "2010", "pages" => "135", "author" => "39", "bookfile" => "uploads/pdf/39.pdf", "bookImage" => "uploads/image/book/39.png"],
            ["name" => "Guýulary barlamagyň elektrik we magnit usullary", "year" => "2010", "pages" => "97", "author" => "40", "bookfile" => "uploads/pdf/40.pdf", "bookImage" => "uploads/image/book/40.png"],
            ["name" => "Maliýe seljermesi", "year" => "2010", "pages" => "121", "author" => "41", "bookfile" => "uploads/pdf/41.pdf", "bookImage" => "uploads/image/book/41.png"],
            ["name" => "Assembler ulgamlaýyn maksatnama dili", "year" => "2010", "pages" => "134", "author" => "42", "bookfile" => "uploads/pdf/42.pdf", "bookImage" => "uploads/image/book/42.png"],
            ["name" => "Pudagyň häzirki zaman dünýä tejribesi", "year" => "2010", "pages" => "108", "author" => "43", "bookfile" => "uploads/pdf/43.pdf", "bookImage" => "uploads/image/book/43.png"],
            ["name" => "Ýangyjyň öndürilişi", "year" => "2010", "pages" => "66", "author" => "44", "bookfile" => "uploads/pdf/44.pdf", "bookImage" => "uploads/image/book/44.png"],
            ["name" => "Hekaýalar toplumy 2", "year" => "", "pages" => "80", "author" => "45", "bookfile" => "uploads/pdf/45.pdf", "bookImage" => "uploads/image/book/45.png"],
            ["name" => "Eksperimental psihologiýa", "year" => "2010", "pages" => "108", "author" => "46", "bookfile" => "uploads/pdf/46.pdf", "bookImage" => "uploads/image/book/46.png"],
            ["name" => "Wentilýasiýa we howany kondisionirleme", "year" => "2010", "pages" => "97", "author" => "47", "bookfile" => "uploads/pdf/47.pdf", "bookImage" => "uploads/image/book/47.png"],
            ["name" => "Awtomatiki dolandyrmagyň we sazlamagyň nazaryýeti", "year" => "2010", "pages" => "101", "author" => "48", "bookfile" => "uploads/pdf/48.pdf", "bookImage" => "uploads/image/book/48.png"],
            ["name" => "Önümçiligi guramak we dolandyrmak ", "year" => "2010", "pages" => "115", "author" => "50", "bookfile" => "uploads/pdf/49.pdf", "bookImage" => "uploads/image/book/49.png"],
            ["name" => "Gurluşyk üçin inžener geologik gözlegler", "year" => "2010", "pages" => "109", "author" => "51", "bookfile" => "uploads/pdf/50.pdf", "bookImage" => "uploads/image/book/50.png"],
            ["name" => "Karýerlerde daşky guşawy goramak", "year" => "2010", "pages" => "87", "author" => "52", "bookfile" => "uploads/pdf/51.pdf", "bookImage" => "uploads/image/book/51.png"],
            ["name" => "Söýgi kelamy", "year" => "2016", "pages" => "152", "author" => "53", "bookfile" => "uploads/pdf/52.pdf", "bookImage" => "uploads/image/book/52.png"],
            ["name" => "Sosiologiýa", "year" => "2010", "pages" => "169", "author" => "54", "bookfile" => "uploads/pdf/53.pdf", "bookImage" => "uploads/image/book/53.png"],
            ["name" => "Hukuk psihologiýasy", "year" => "2010", "pages" => "148", "author" => "55", "bookfile" => "uploads/pdf/54.pdf", "bookImage" => "uploads/image/book/54.png"],
            ["name" => "Tebigatdan peýdalanmagyň ykdysatyýeti", "year" => "2010", "pages" => "103", "author" => "56", "bookfile" => "uploads/pdf/55.pdf", "bookImage" => "uploads/image/book/55.png"],
            ["name" => "Formasiýa derňewi", "year" => "2010", "pages" => "82", "author" => "57", "bookfile" => "uploads/pdf/56.pdf", "bookImage" => "uploads/image/book/56.png"],
            ["name" => "Biofizika", "year" => "2010", "pages" => "107", "author" => "58", "bookfile" => "uploads/pdf/57.pdf", "bookImage" => "uploads/image/book/57.png"],
            ["name" => "Biotehnologiýa", "year" => "2010", "pages" => "66", "author" => "59", "bookfile" => "uploads/pdf/58.pdf", "bookImage" => "uploads/image/book/58.png"],
            ["name" => "Emosiýalaryň psihologiýalary", "year" => "2010", "pages" => "128", "author" => "60", "bookfile" => "uploads/pdf/59.pdf", "bookImage" => "uploads/image/book/59.png"],
            ["name" => "Dünýä ykdysadyýeti", "year" => "2010", "pages" => "128", "author" => "61", "bookfile" => "uploads/pdf/60.pdf", "bookImage" => "uploads/image/book/60.png"],
            ["name" => "Könürgenç rowaýatlary", "year" => "1993", "pages" => "80", "author" => "62", "bookfile" => "uploads/pdf/61.pdf", "bookImage" => "uploads/image/book/61.png"],
            ["name" => "Pudagyň ykdysadyýeti", "year" => "2010", "pages" => "109", "author" => "63", "bookfile" => "uploads/pdf/62.pdf", "bookImage" => "uploads/image/book/62.png"],
            ["name" => "Aýananyň tehnologiýasy", "year" => "2010", "pages" => "106", "author" => "64", "bookfile" => "uploads/pdf/63.pdf", "bookImage" => "uploads/image/book/63.png"],
            ["name" => "Programirlemegiň tilsimaty", "year" => "2010", "pages" => "132", "author" => "65", "bookfile" => "uploads/pdf/64.pdf", "bookImage" => "uploads/image/book/64.png"],
            ["name" => "Grawimetrik we magnitometrik barlag", "year" => "2011", "pages" => "62", "author" => "66", "bookfile" => "uploads/pdf/65.pdf", "bookImage" => "uploads/image/book/65.png"],
            ["name" => "Geologik gurşawy goramak", "year" => "2010", "pages" => "133", "author" => "67", "bookfile" => "uploads/pdf/66.pdf", "bookImage" => "uploads/image/book/66.png"],
            ["name" => "Petrografiýa we litologiýa", "year" => "2010", "pages" => "156", "author" => "68", "bookfile" => "uploads/pdf/67.pdf", "bookImage" => "uploads/image/book/67.png"],
            ["name" => "Grawimetriki barlaglar", "year" => "2010", "pages" => "101", "author" => "69", "bookfile" => "uploads/pdf/68.pdf", "bookImage" => "uploads/image/book/68.png"],
            ["name" => "Maglumat hadysalaryň we dolandyryşyň matematiki modelleri", "year" => "2010", "pages" => "61", "author" => "70", "bookfile" => "uploads/pdf/69.pdf", "bookImage" => "uploads/image/book/69.png"],
            ["name" => "Ölçeg serişdeleriniň düzümi we elementleri", "year" => "2010", "pages" => "68", "author" => "71", "bookfile" => "uploads/pdf/70.pdf", "bookImage" => "uploads/image/book/70.png"],
            ["name" => "Inžener-geologik işleriň usulyýeti", "year" => "2010", "pages" => "111", "author" => "72", "bookfile" => "uploads/pdf/71.pdf", "bookImage" => "uploads/image/book/71.png"],
            ["name" => "Metrologiýa", "year" => "2010", "pages" => "136", "author" => "73", "bookfile" => "uploads/pdf/72.pdf", "bookImage" => "uploads/image/book/72.png"],
            ["name" => "On ýedimiň bahary", "year" => "", "pages" => "144", "author" => "74", "bookfile" => "uploads/pdf/73.pdf", "bookImage" => "uploads/image/book/73.png"],
            ["name" => "Struktura geologiýasy", "year" => "2010", "pages" => "95", "author" => "75", "bookfile" => "uploads/pdf/74.pdf", "bookImage" => "uploads/image/book/74.png"],
            ["name" => "Pikirlenmäniň we sözleýişiň psihologiýasy", "year" => "2010", "pages" => "136", "author" => "76", "bookfile" => "uploads/pdf/75.pdf", "bookImage" => "uploads/image/book/75.png"],
            ["name" => "Zähmeti goramak", "year" => "2010", "pages" => "91", "author" => "77", "bookfile" => "uploads/pdf/76.pdf", "bookImage" => "uploads/image/book/76.png"],
            ["name" => "Ylmy barlaglaryň esaslary", "year" => "2010", "pages" => "66", "author" => "78", "bookfile" => "uploads/pdf/77.pdf", "bookImage" => "uploads/image/book/77.png"],
            ["name" => "Sertifikasiýa", "year" => "2010", "pages" => "87", "author" => "79", "bookfile" => "uploads/pdf/78.pdf", "bookImage" => "uploads/image/book/78.png"],
            ["name" => "Taryhy okatmagyň usulyýeti", "year" => "2010", "pages" => "118", "author" => "80", "bookfile" => "uploads/pdf/79.pdf", "bookImage" => "uploads/image/book/79.png"],
            ["name" => "Ekologiki menejment we ekologiki audit", "year" => "2010", "pages" => "110", "author" => "81", "bookfile" => "uploads/pdf/80.pdf", "bookImage" => "uploads/image/book/80.png"],
            ["name" => "Kriogen tehnikasy", "year" => "2010", "pages" => "81", "author" => "82", "bookfile" => "uploads/pdf/81.pdf", "bookImage" => "uploads/image/book/81.png"],
            ["name" => "Bagtym hem ýyldyzym", "year" => "", "pages" => "143", "author" => "73", "bookfile" => "uploads/pdf/82.pdf", "bookImage" => "uploads/image/book/82.png"],
            ["name" => "Harry Potter", "year" => "", "pages" => "293", "author" => "83", "bookfile" => "uploads/pdf/83.pdf", "bookImage" => "uploads/image/book/83.png"],
            ["name" => "Müň bir gije", "year" => "1978", "pages" => "267", "author" => "84", "bookfile" => "uploads/pdf/84.pdf", "bookImage" => "uploads/image/book/84.png"],
            ["name" => "Teke atly polkunyň söweş ýoly", "year" => "2013", "pages" => "216", "author" => "85", "bookfile" => "uploads/pdf/85.pdf", "bookImage" => "uploads/image/book/85.png"],
            ["name" => "Mikroelektronyň tehnologiýasy", "year" => "2010", "pages" => "125", "author" => "86", "bookfile" => "uploads/pdf/86.pdf", "bookImage" => "uploads/image/book/86.png"],
            ["name" => "Organiki himiýa", "year" => "2009", "pages" => "336", "author" => "87", "bookfile" => "uploads/pdf/87.pdf", "bookImage" => "uploads/image/book/87.png"],
            ["name" => "C/C++ meseleler", "year" => "2013", "pages" => "246", "author" => "", "bookfile" => "uploads/pdf/88.pdf", "bookImage" => "uploads/image/book/88.png"],
            ["name" => "Guýulary ýerasty we düýpli abatlamak", "year" => "2010", "pages" => "106", "author" => "89", "bookfile" => "uploads/pdf/90.pdf", "bookImage" => "uploads/image/book/90.png"],
            ["name" => "Ykdysady-matematiki modeller", "year" => "2010", "pages" => "68", "author" => "90", "bookfile" => "uploads/pdf/91.pdf", "bookImage" => "uploads/image/book/91.png"],
            ["name" => "Umumy himiýa tehnologiýasy", "year" => "2010", "pages" => "66", "author" => "91", "bookfile" => "uploads/pdf/92.pdf", "bookImage" => "uploads/image/book/92.png"],
            ["name" => "Ähtimallyklar teoriýasy we matematiki statistika", "year" => "2010", "pages" => "117", "author" => "92", "bookfile" => "uploads/pdf/93.pdf", "bookImage" => "uploads/image/book/93.png"],
            ["name" => "Geologiýada ulanylýan alyslaýyn usullar", "year" => "2010", "pages" => "83", "author" => "93", "bookfile" => "uploads/pdf/94.pdf", "bookImage" => "uploads/image/book/94.png"],
            ["name" => "Adamyň ekologiýasy", "year" => "2010", "pages" => "69", "author" => "94", "bookfile" => "uploads/pdf/95.pdf", "bookImage" => "uploads/image/book/95.png"],
            ["name" => "Elektrik enjamlarynyň gurnalyşy we ulanylyşy", "year" => "2010", "pages" => "94", "author" => "95", "bookfile" => "uploads/pdf/96.pdf", "bookImage" => "uploads/image/book/96.png"],
            ["name" => "korroziýadan goramak", "year" => "2010", "pages" => "77", "author" => "96", "bookfile" => "uploads/pdf/97.pdf", "bookImage" => "uploads/image/book/97.png"],
            ["name" => "Mikroelektron ulgamlarynyň san modelleri", "year" => "2010", "pages" => "83", "author" => "97", "bookfile" => "uploads/pdf/98.pdf", "bookImage" => "uploads/image/book/98.png"],
            ["name" => "Maglumat gory we banklary", "year" => "2010", "pages" => "92", "author" => "98", "bookfile" => "uploads/pdf/99.pdf", "bookImage" => "uploads/image/book/99.png"],
            ["name" => "Motiwasion psihologiýasy", "year" => "2010", "pages" => "131", "author" => "99", "bookfile" => "uploads/pdf/100.pdf", "bookImage" => "uploads/image/book/100.png"],
            ["name" => "Halkara standartlary we sertifikatlary", "year" => "2010", "pages" => "77", "author" => "100", "bookfile" => "uploads/pdf/101.pdf", "bookImage" => "uploads/image/book/101.png"],
            ["name" => "Maslahatyņ we anyklaýşyņ psihologiýasy", "year" => "2010", "pages" => "169", "author" => "101", "bookfile" => "uploads/pdf/102.pdf", "bookImage" => "uploads/image/book/102.png"],
            ["name" => "Derdeser", "year" => "2013", "pages" => "206", "author" => "102", "bookfile" => "uploads/pdf/103.pdf", "bookImage" => "uploads/image/book/103.png"],
            ["name" => "Konstruirlemegiň çeperçilik esaslary", "year" => "2010", "pages" => "97", "author" => "103", "bookfile" => "uploads/pdf/104.pdf", "bookImage" => "uploads/image/book/104.png"],
            ["name" => "Pudagyň hasabaty", "year" => "2010", "pages" => "130", "author" => "104", "bookfile" => "uploads/pdf/105.pdf", "bookImage" => "uploads/image/book/105.png"],
            ["name" => "Grawimetriýa", "year" => "2010", "pages" => "123", "author" => "105", "bookfile" => "uploads/pdf/106.pdf", "bookImage" => "uploads/image/book/106.png"],
            ["name" => "Ekologiki monitoring", "year" => "2010", "pages" => "120", "author" => "106", "bookfile" => "uploads/pdf/107.pdf", "bookImage" => "uploads/image/book/107.png"],
            ["name" => "Anyk işlere niýetlenen komputer serişdesi", "year" => "2010", "pages" => "84", "author" => "107", "bookfile" => "uploads/pdf/108.pdf", "bookImage" => "uploads/image/book/108.png"],
            ["name" => "Geçiji maşynlar", "year" => "2010", "pages" => "87", "author" => "108", "bookfile" => "uploads/pdf/109.pdf", "bookImage" => "uploads/image/book/109.png"],
            ["name" => "Rubagylar", "year" => "2012", "pages" => "180", "author" => "109", "bookfile" => "uploads/pdf/110.pdf", "bookImage" => "uploads/image/book/110.png"],
            ["name" => "Ulgamlaýyn derňew we amallary derňeme", "year" => "2010", "pages" => "89", "author" => "110", "bookfile" => "uploads/pdf/111.pdf", "bookImage" => "uploads/image/book/111.png"],
            ["name" => "Beýik köňle syýahat", "year" => "", "pages" => "187", "author" => "111", "bookfile" => "uploads/pdf/112.pdf", "bookImage" => "uploads/image/book/112.png"],
            ["name" => "Filosofiýa", "year" => "2010", "pages" => "221", "author" => "112", "bookfile" => "uploads/pdf/113.pdf", "bookImage" => "uploads/image/book/113.png"],
            ["name" => "Kalbyma syýahat", "year" => "2006", "pages" => "600", "author" => "113", "bookfile" => "uploads/pdf/114.pdf", "bookImage" => "uploads/image/book/114.png"],
            ["name" => "Toksikologiýa", "year" => "2010", "pages" => "140", "author" => "114", "bookfile" => "uploads/pdf/115.pdf", "bookImage" => "uploads/image/book/115.png"],
            ["name" => "Hil menejmentleriň ulgamlary", "year" => "2010", "pages" => "123", "author" => "115", "bookfile" => "uploads/pdf/116.pdf", "bookImage" => "uploads/image/book/116.png"],
            ["name" => "Kompýuter maglumatlaryny goramagyň usullary we serişdeleri", "year" => "2010", "pages" => "74", "author" => "116", "bookfile" => "uploads/pdf/117.pdf", "bookImage" => "uploads/image/book/117.png"],
            ["name" => "Kompýuterde programmalaşdyrmak arkally meseleleri çözmek", "year" => "2012", "pages" => "58", "author" => "117", "bookfile" => "uploads/pdf/118.pdf", "bookImage" => "uploads/image/book/118.png"],
            ["name" => "Ýyladyş we ýylylyk emele getiriji desgalar", "year" => "2010", "pages" => "91", "author" => "119", "bookfile" => "uploads/pdf/120.pdf", "bookImage" => "uploads/image/book/120.png"],
            ["name" => "Burawlamakda gidroaeromehanika", "year" => "2010", "pages" => "86", "author" => "120", "bookfile" => "uploads/pdf/121.pdf", "bookImage" => "uploads/image/book/121.png"],
            ["name" => "Taryhy geologiýa", "year" => "2010", "pages" => "138", "author" => "121", "bookfile" => "uploads/pdf/122.pdf", "bookImage" => "uploads/image/book/122.png"],
            ["name" => "Zähmeti goramak 2", "year" => "2010", "pages" => "172", "author" => "122", "bookfile" => "uploads/pdf/123.pdf", "bookImage" => "uploads/image/book/123.png"],
            ["name" => "Gurluşyk önümçilik guramaçylygy we dolandyrylyşy", "year" => "2010", "pages" => "124", "author" => "123", "bookfile" => "uploads/pdf/124.pdf", "bookImage" => "uploads/image/book/124.png"],
            ["name" => "Gaz üpjünçiligi", "year" => "2010", "pages" => "129", "author" => "124", "bookfile" => "uploads/pdf/125.pdf", "bookImage" => "uploads/image/book/125.png"],
            ["name" => "Iner ýüki", "year" => "2006", "pages" => "485", "author" => "125", "bookfile" => "uploads/pdf/126.pdf", "bookImage" => "uploads/image/book/126.png"],
            ["name" => "Maşynlary döretmegiň esaslary", "year" => "2010", "pages" => "94", "author" => "126", "bookfile" => "uploads/pdf/127.pdf", "bookImage" => "uploads/image/book/127.png"],
            ["name" => "Awtomatlaşdyrylan ulgamlary taslamak", "year" => "2010", "pages" => "189", "author" => "127", "bookfile" => "uploads/pdf/128.pdf", "bookImage" => "uploads/image/book/128.png"],
            ["name" => "Suw baýlyklaryny tygşytly ulanmak", "year" => "2010", "pages" => "96", "author" => "128", "bookfile" => "uploads/pdf/129.pdf", "bookImage" => "uploads/image/book/129.png"],
            ["name" => "Awtomatlaşdyrylan maglumat ulgamlary", "year" => "2010", "pages" => "101", "author" => "129", "bookfile" => "uploads/pdf/130.pdf", "bookImage" => "uploads/image/book/130.png"],
            ["name" => "Energetiki gurnamalar", "year" => "2010", "pages" => "87", "author" => "130", "bookfile" => "uploads/pdf/131.pdf", "bookImage" => "uploads/image/book/131.png"],
            ["name" => "Bazary öwreniş", "year" => "2010", "pages" => "224", "author" => "131", "bookfile" => "uploads/pdf/132.pdf", "bookImage" => "uploads/image/book/132.png"],
            ["name" => "Geologiýada matematiki usullar", "year" => "2010", "pages" => "114", "author" => "132", "bookfile" => "uploads/pdf/133.pdf", "bookImage" => "uploads/image/book/133.png"],
            ["name" => "Fizikadan meseleler", "year" => "2010", "pages" => "134", "author" => "133", "bookfile" => "uploads/pdf/134.pdf", "bookImage" => "uploads/image/book/134.png"],
            ["name" => "Meýadan geofizikasy", "year" => "2010", "pages" => "112", "author" => "134", "bookfile" => "uploads/pdf/135.pdf", "bookImage" => "uploads/image/book/135.png"],
            ["name" => "Iklenji energoresurslar", "year" => "2010", "pages" => "128", "author" => "135", "bookfile" => "uploads/pdf/136.pdf", "bookImage" => "uploads/image/book/136.png"],
            ["name" => "Psihofiziologiýa", "year" => "2010", "pages" => "80", "author" => "136", "bookfile" => "uploads/pdf/137.pdf", "bookImage" => "uploads/image/book/137.png"],
            ["name" => "Daş-töweregiň himiýasy", "year" => "2010", "pages" => "109", "author" => "137", "bookfile" => "uploads/pdf/138.pdf", "bookImage" => "uploads/image/book/138.png"],
            ["name" => "Ýylylyk tehnikasynyň ölçegleri", "year" => "2010", "pages" => "159", "author" => "138", "bookfile" => "uploads/pdf/139.pdf", "bookImage" => "uploads/image/book/139.png"],
            ["name" => "Geomaglumatlar ulgamy", "year" => "2010", "pages" => "139", "author" => "139", "bookfile" => "uploads/pdf/140.pdf", "bookImage" => "uploads/image/book/140.png"],
            ["name" => "Dag gazuw işleri", "year" => "2010", "pages" => "94", "author" => "140", "bookfile" => "uploads/pdf/141.pdf", "bookImage" => "uploads/image/book/141.png"],
            ["name" => "Özaraçalşyk we metrologiýa", "year" => "2010", "pages" => "166", "author" => "141", "bookfile" => "uploads/pdf/142.pdf", "bookImage" => "uploads/image/book/142.png"],
            ["name" => "Matematiki modelleri EHM-de hasaplamak", "year" => "2010", "pages" => "52", "author" => "143", "bookfile" => "uploads/pdf/144.pdf", "bookImage" => "uploads/image/book/144.png"],
            ["name" => "Geodeziki astronomiýa", "year" => "2010", "pages" => "108", "author" => "144", "bookfile" => "uploads/pdf/145.pdf", "bookImage" => "uploads/image/book/145.png"],
            ["name" => "Ulag maşynlary", "year" => "2010", "pages" => "102", "author" => "145", "bookfile" => "uploads/pdf/146.pdf", "bookImage" => "uploads/image/book/146.png"],
            ["name" => "Geohimiýa", "year" => "2010", "pages" => "94", "author" => "147", "bookfile" => "uploads/pdf/148.pdf", "bookImage" => "uploads/image/book/148.png"],
            ["name" => "Gel köňlüm,seýran edel…", "year" => "2005", "pages" => "61", "author" => "149", "bookfile" => "uploads/pdf/150.pdf", "bookImage" => "uploads/image/book/150.png"],

        ];
        foreach ($books as $item) {
            $bookFile = new Media();
            $bookFile->setBinaryContent(realpath($this->kernelRootDir).'/web/'.$item['bookfile']);
            $bookFile->setContext('book');
            $bookFile->setCategory($contexts['book']['context']->category);
            $bookFile->setProviderName('sonata.media.provider.file');

            $bookImage = new Media();
            $bookImage->setBinaryContent(realpath($this->kernelRootDir).'/web/'.$item['bookImage']);
            $bookImage->setContext('book');
            $bookImage->setCategory($contexts['book']['context']->category);
            $bookImage->setProviderName('sonata.media.provider.image');

            $manager->persist($bookFile);
            $manager->persist($bookImage);

            $book = new Book();
            $book->setBookFile($bookFile);
            $book->setBookImage($bookImage);
            if (isset($item['description'])) $book->setDescription($item['description']);
            $book->setName($item["name"]);
            if ((int)$item["year"] > 0) $book->setYear((int)$item["year"]);
            $tmp = explode(',', $item['author']);
            $item['author'] = [];
            foreach ($tmp as $t) {
                $t = (int)trim($t);
                if ($t > 0) {
                    if (isset($authors[$t]["author"])) $item['author'][] = $authors[$t]["author"];
                }
            }
            $book->setAuthors(new ArrayCollection($item["author"]));
            $book->setPageCount((int)$item['pages']);

            $manager->persist($book);
        }
        $manager->flush();


        // Resources
        $resources = [
            [
                "name" => "Kompýuteriň düzümi",
                "content" => '<p style="text-align: justify;">Kompýuterler – adamyň işinde, ýaşaýyş durmuşynda onuň ygtybarly kömekçisidir. Kompýuteriň kömegi bilen howa maglumaty düzülýär, uçarlaryň, maşynlaryň çyzgylary taýýarlanýar, näsaglaryň kesellerini anyklaýyş işleri ýerine ýetirilýär, multfilmler, saz kompozisiýalary we ş.m. döredilýär. Kompýuter otlularyň gatnawy baradaky informasiýany hödürleýär, internet (www.ylymly.com) dükanlardan söwda etmäge, banklarda adamlaryň töleglerini tölemäge mümkinçilik berýär. Kompýuterleriň görnüşleriniň we ýerine ýetirýän işleriniň dürlüligine garamazdan, olaryň düzümi birmeňzeşdir.</p>
<p style="text-align: justify;">Her bir kompýuter <strong>sistema blogundan,</strong> <strong>monitordan, klawiaturadan </strong>we <strong>syçandan </strong>durýar. Bu düzüm bölekleriniň her biri kesgitli wezipeleri ýerine ýetirýärler.</p>
<p style="text-align: justify;">Mundan başga-da kompýutere <strong>skaner</strong> we <strong>printer</strong> ýaly gurluşlar hem çatylyp bilner. Giriş we çykyş gurluşlary <em>sistema bloguna </em>çatylýar. Sistema blogunda informasiýalary işläp taýýarlamagy we saklamagy amala aşyrýan möhüm gurluşlar ýerleşendir. <em>Sistema blogy </em>dürli görnüşlerde bolup biler.</p>
<p style="text-align: justify;"><strong>Monitor</strong> (oňa <em>displeý </em>hem diýilýär) – işlenip taýýarlanan informasiýalaryň netijelerini ekrana çykarýan gurluşdyr.</p>
<p style="text-align: justify;"><strong>Klawiatura</strong> – kompýutere tekst informasiýalaryny we kompýuteri dolandyrýan buýruklary girizmek üçin ulanylýan gurluşdyr. <em>Klawiatura </em><strong>– </strong>kompýutere informasiýalary girizýän esasy gurluşdyr. Klawişleri şertleýin bäş topara bölmek bolar.</p>
<p style="text-align: justify;">1) belgileri girizmek üçin niýetlenen elipbiý-sifrli klawişler;</p>
<p style="text-align: justify;">2) klawiaturanyň iş kadasyny üýtgedýän dolandyryjy klawişler;</p>
<p style="text-align: justify;">3) kursory aşak-ýokary, çepe-saga süýşürýän, ýagny kursory dolandyryjy klawişler;</p>
<p style="text-align: justify;">4) sanlary we arifmetiki amallaryň belgilerini girizýän goşmaça sifr klawişler;</p>
<p style="text-align: justify;">5) dürli programmalarda dürli işleri ýerine ýetirýän funksional klawişler (meselem: F1 klawişi köplenç, şol programmany ulanmakda we kömekçini çagyrmak üçin peýdalanylýar).</p>
<p style="text-align: justify;">Teksti girizmek üçin niýetlenen her klawişiň ýüzünde adatça iki belgi: iňlis we rus harpy şekillendirilendir. &nbsp;Elipbiýleri birinden beýlekisine geçirmegiň usuly (<strong>Alt +Shift; Ctrl+Shift; Shift+Shift</strong>) klawiaturanyň sazlanyşyna baglydyr. Klawişleriň atlarynyň arasyndaky <strong>«+» </strong>belgisi 1-nji klawişi basyp saklap, soň 2-nji klawişi basmalydygyny, ýagny klawişleri utgaşdyryp basmalydygyny aňladýar. 2.6-njy suratda <strong>Ctrl + Shift </strong>klawişleri utgaşykly ulanmagyň amallary görkezilendir.</p>
<p style="text-align: justify;">Her elipbiýiň harplary baş we setir harp görnüşinde bolup biler. Eger diňe bir baş harp gerek bolsa, ondaklawişleriň <strong>Shift+harp </strong>utgaşmasyny ulanmak amatlydyr. Eger birnäçe baş harp gerek bolsa, <strong>Caps Lock </strong>klawişi basmak maslahat berilýär. Klawiaturanyň elipbiý-sifirli böleginiň ýokarky hatarynyň klawişlerinde sifrler we simwollar şekillendirilendir. Şol klawişlere basylanda, olardaky aşaky simwollar girizilýär. Ýokarky simwollary girizmek üçin bolsa, <strong>Shift </strong>we girizilýän simwolyň klawişi utgaşykly basylýar. Tekst girizilende, sözleriň arasy boşluk klawişini basmak arkaly bölünýär. Informasiýanyň girizilendigini tassyklamak üçin <strong>Enter </strong>klawişi, buýruklary ýatyrmak üçin <strong>ESC </strong>klawişi ulanylýar. Klawiatura bilen işlemegi öwretmek üçin, klawiatura türgenleşdiriji ýörite programmalar ulanylýar. Olaryň kömegi bilen tekstleri ýazmagyň usullaryny öwrenip bolar. Bu usulda klawiaturanyň her bir klawişine çep ýada sag eliň barmaklary degişli edilýär we gerekli ýerinde barmaklar şol harplary girizýärler. Kompýuteriň ekranynda obýektleri görkezmek, surat çekmek we ş.m. işler üçin syçany ulanmak bolar.</p>
<p style="text-align: justify;"><strong>Tekst kursory </strong>– bu ýanyp-sönüp duran dik kesimi ýada salýar. Ol klawiaturadan giriziljek belginiň ýazyljak ýerini görkezýär. Syçanyň <strong>kursory </strong>bolsa ýapgyt ugur görkezgiç (peýkam oky) görnüşindedir. Syçanyň süýşürilmegi bilen ekranda kursor hem süýşýär. Syçanyň bir tigirjigi we iki sany gulagy (çep we sag düwmesi) bolýar. Tigirjik adatça tekst gözden geçirilende ulanylýar. Syçanyň çep gulagy bir gezek ýa-da iki gezek çalt basylyp ulanylýar. Eger siz sag eliňiz bilen işleýän bolsaňyz, onda syçanyň çep gulagy esasydyr.</p>
<p style="text-align: justify;"><strong>Printer</strong> – tekst we grafiki informasiýalary kagyza çykarýan enjamdyr. Printerleriň matrisaly, akymly we lazer görnüşleri bardyr.<strong>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></p>
<p style="text-align: justify;"><strong>Çeşme:</strong>&nbsp;Türkmenistanyň Bilim ministrligi tarapyndan taýýarlanan, 6-njy synplar üçin “Informatika we informasiýa tehnologiýalary” dersi boýunça okuw kitaby</p>'
            ],
            [
                "name" => "Gadymy rimlileriň medeniýeti",
                "content" => '<p style="text-align: justify;"><strong>Etrusklaryň medeniýeti. </strong>Apennin ýarym adasynyň bir bölegi bolan Etruriýada (häzirki Toskana) m.öňki I müňýyllykda gadymy etrusk taýpalary ösen siwilizasiýany döredipdirler. Ol barada grek we rim awtorlarynyň (Gerodot, Diodor, Strabon, Tit Liwiý, Uly Pliniý) ýazgylary we etrusk mazarlaryndan hem-de gonalgalaryndan tapylan arheologik tapyndylar köp maglumatlary berýär. Miladydan öňki IV asyra degişli Tarkwinidäki etrusk gonamçylygyndan tapylan freskalardaky sazandalaryň suratlary, şol ýerde ýüze çykarylan m. öňki V asyra degişli şekiller şol döwrüň özboluşly medeniýetini hem-de sungatyny açyp görkezýär. Gazuw-agtaryşlaryň netijesinde 10 müňe golaý etrusk ýazgylary tapylypdyr. Emma şeýle-de bolsa, etrusklaryň gelip çykyşy we olaryň döreden baý medeniýeti bilen baglanyşykly çözülmän ýatan meseleler bardyr. Etruriýada bürünç we demir magdanlary gazylyp alnypdyr. Etrusklar rim jemgyýetiniň mifologiýasyna we dinine öz täsirini ýetiripdir. Italiýanyň taýpalary Orta we Demirgazyk Italiýa Etruriýanyň üsti arkaly grek hatyny Kabul edipdirler. Ybadathanalaryň, köşkleriň, köprüleriň, kanallaryň we gala diwarlarynyň galyndylarynyň saklanyp galmagy şol döwürde medeniýetiň ösendigine şaýatlyk edýär. Etruriýada bürünçden ýasalan heýkeller we reňklenen terrakotalar (gyzylymtyl-goňur reňkli bişirilen toýundan edilen heýkeljikler), sebetler, tabytlar, metaldan, altyndan edilen önümler ýasalypdyr.</p>
<p style="text-align: justify;"><strong>Gadymy Rim medeniýetiniň kemala gelmeginde etrusklaryň, grekleriň we basylyp alnan ýurtlaryň ilatynyň täsiri. </strong>Rimde ylmyň hem-de medeniýetiň ösüşine etrusklaryň we grekleriň bu ugurda gazananlary uly täsir edipdir. Aýratyn hem bu täsir binagärlikde güýçli duýlupdyr. Rimliler hem öz gezeginde etrusk medeniýetiniň ösüşine täsir edipdirler. Kitaphanalar, ybadathanalar, teatrlar, köşkler we gaýry desgalar grek däbine laýyklykda bina edilipdir. Miladydan öňki IV asyrda Etruriýadan köp etrusk ilaty göçüp gelip, Rimde mesgen tutupdyr. Şunuň netijesinde etrusklaryň ýaşaýan ýerinde şäheriň aýratyn bir bölegi emele gelipdir. Külalçylyk we zergärçilik sungatynda rim medeniýetine italiýalylar hem öz täsirini ýetiripdirler. Rimiň irki sungatynda italiýalylaryň, etrusklaryň, grekleriň täsiri giňden ýaýbaňlanypdyr. Eneýa, Romul we Rem hakyndaky rowaýatlar rimlilere Etruriýanyň üsti arkaly gelip ýetipdir. Grek-makedon ilaty hem her bir şäheriň medeni durmuşyna täsiredipdir.</p>
<p style="text-align: justify;"><strong>Nusgawy rim binagärligi. </strong>Miladynyň 75–80-nji ýyllarynda Gadymy Rimde tomaşa jaýy bolan Kolizeý ýa-da «Flawileriň amfiteatry» diýip at alan ajaýyp bina gurlupdyr. Oňa bir wagtda 50 müň tomaşaçy ýerleşip bilýär eken. Kolizeý ýyrtyjy haýwanlary uruşdyrmak, gladiatorlaryň söweşini geçirmek, at çapyşyklary we beýleki oýunlary guramak üçin niýetlenilipdir. Kolizeýiň gurluşygynda rim binagärliginiň esasy gurluşyk serişdeleri bolan tuf we trawert daşlary, onuň galereýalarynyň gurluşygynda bolsa kerpiç bilen mermer ulanylypdyr. Amfiteatrdaky heýkeller saklanmandyr, ýöne onuň diwarlarynyň ýüzi ýarym sütünleri ýatladyp duran pilýastralar we arkalar ýaly gurluşyk ülňüleri bilen baý bezelipdir. Şäheriň möhüm gurluşyk desgalarynyň arasynda Rim forumy aýratyn uly ähmiýete eýe bolupdyr. Rim forumy töweregindäki binalary özünde jemleýän binalar toplumy bolup, ol şäheriň jemgyetçilik-syýasy durmuşynyň jemlenen ýerine öwrülipdir. Bu desga miladydan öňki VI asyrdaasly Damaskdan bolan Apollodor tarapyndan gurlupdyr. Başda forumyň ýerinde şäher bazary bolupdyr, soňra ol halk ýygnaklarynyň geçirilýän ýeri bolan komisini, Senatyň ýygnagy geçýän kuriýany hem özüne birikdiripdir.</p>
<p style="text-align: justify;">Gadymy Rimde ähli hudaýlaryň heýkelleriniň jemlenen ýeri bolan <strong>Panteon</strong> gurlupdyr. Bu desga miladynyň 125‑nji ýylynda rim serkerdesi hem-de döwlet işgäri Awgustyň egindeşi Mark Wipsaniý Agrippa (m. ö. 63-nji ýyl– miladynyň 12-nji ýyly) tarapyndan bina edilip, onuň gümmezi&nbsp; 43 metre barabar bolupdyr. Gümmez daş garnuwdan (betondan) we kerpiçden gurlup, gurluş taýdan gümmezi saklaýan diwarlardan, içinden iki setir edilip bölünen galereýadan, iç tarapy bolsa ýedi sany tagçalardan ybarat bolupdyr. Rim binagärlik sungatynyň ajaýyp desgalarynyň biri-de Dabaraly derwezelerdir (Triumfal arkalar). Dabaraly derwezelerRim jemgyýetiniň durmuşynda bolup geçýän möhümwakalary dabaralandyrmak hem-de şöhratlandyrmak üçin wagtlaýyn ýa-da hemişelik gurulýan kaşaň desgalar bolupdyr. Dabaraly derwezeleriň gurluşygynda rim binagärliginde ýörgünli bolan dürli binagärlik ülňüleri we bezegler ulanylypdyr. Bu desgalarda oturdylan heýkeller, şekillendirilen relýefler we ýadygärlik ýazgylary görenleri haýran galdyrypdyr. Şeýle desgalaryň hatarynda Titanyň(81-nji ýyl) we Konstantiniň (315-nji ýyl) dabaraly derwezelerini mysal hökmünde görkezmek bolar.</p>
<p style="text-align: justify;">Tomus günleri Italiýada yssy epgek öwsüpdir. Şonuň üçin hem gadymy döwürlerde daglardan we köllerden ýerasty turba geçirijiler arkaly Rime suw akdyrylypdyr. Şeýle suw geçirijileriniň ilkinjileriniň biri miladydan öňki 504-nji ýylda Appiý Klawdiý Sabina tarapyndan gurlupdyr. Rim şäheriniň Tibr derýasynyň boýunda ýerleşmegi derýanyň üstünden köprüleri gurmagyň zerurlygyny döredipdir. Şonuň üçin Rimde daşdan birnäçe gadymy köprüler gurlupdyr.</p>
<p style="text-align: justify;">Rimde teatrlaryň ýüze çykmagy gadymy baýramçylyklar, esasan hem, hasyl toýlary bilen baglanyşykly bolupdyr. Teatrlarda gülküli sahnalar, tanslar, aýdym-sazlar ýaňlanypdyr. Miladydan öňki III asyryň ahyrlarynda halk tomaşalarynyň täze bir mimika görnüşi has giň gerim alypdyr. Onda ýüzüň-gözüň hereketi, üm (ýagny mimika)we ses bilen çykyş edilipdir. Gerodyň (miladydan öňki III asyr) eoliý şiwesinde papirusa ýazylan mimleriň giň halk köpçüligine hödürlenen ýazgylary bolupdyr. Teatr üçin hemişelik niýetlenen ýörite ýer bolmandyr. Şonuň üçin ilki-ilkiler ybadathananyň golaýynda oýunlar guralypdyr. Ilkinji daşdan salnan teatr miladydan öňki 55–52-nji ýyllarda Pompeý tarapyndan gurlupdyr. M.öňki I asyryň ahyrlarynda Marselle we Balba atly iki sany teatr gurlupdyr. Miladydan öňki III–II asyrlarda artistler adatça nikapsyz çykyş edipdirler, emma has gijiräk nikap geýip çykyş etmek däbe öwrülipdir. M. öňki I asyrda artistçilik sungaty has ösüpdir, ýöne sahnada zenan keşbini erkekler ýerine ýetiripdirler. Rimde imperatorlar tarapyndan şäher medeniýetiniň möhüm alamatlarynyň biri bolan hammamlar (term) köpçülikleýin gurlupdyr. Olaryň sany müňden hem geçipdir. Hammamlaryň gapdalynda dynç alyş otaglary, kitaphanalar we sport meýdançalary bolup, adamlar olaryň hyzmatlaryndan peýdalanyp bilipdirler. Baýramçylyk günleri adamlar sirklere we amfiteatrlara tomaşa görmek üçin barypdyrlar.</p>
<p style="text-align: justify;"><strong>Çeşme:</strong><span style="font-style: inherit; font-weight: inherit;">&nbsp;Türkmenistanyň Bilim ministrligi tarapyndan taýýarlanan, 11-njy synplar üçin “Dünýä Medeniýeti” dersi boýunça okuw kitaby</span></p>',
                "categories" => [],
            ]
        ];
        foreach ($resources as $item) {
            $resource = new Resource();
            $resource->setName($item['name']);
            $resource->setContent($item['content']);
            $manager->persist($resource);
        }
        $manager->flush();


        // Problems
        $problems = [
            [
                "name" => "Setirdäki sanlaryň mukdary",
                "description" => "Girizilen setirde näçe sany sifriň bardygyny kesgitlemek üçin programma ýazmaly.",
                "tests" => [
                    [
                        "input" => "a1b2b3cc",
                        "output" => "3",
                    ],
                    [
                        "input" => "aaaa",
                        "output" => "0",
                    ],
                    [
                        "input" => "1234",
                        "output" => "4",
                    ],
                    [
                        "input" => "a0b",
                        "output" => "1",
                    ],
                ]
            ],
            [
                "name" => "Simwollar bilen gezekleşýän sanlar",
                "description" => "Sanlaryň we latyn elipbiýiniň harplarynyň yzygiderliginden düzülen tekst berlen. Tekstiň sifrler we harplar gezekleşip gelýän iň uzyn bölegini kesgitlemeli.",
                "tests" => [
                    [
                        "input" => "xya2b3cXyz4",
                        "output" => "a2b3c",
                    ],
                    [
                        "input" => "a1b22a",
                        "output" => "a1b2",
                    ],
                    [
                        "input" => "aaaaa1",
                        "output" => "a1",
                    ],
                    [
                        "input" => "a111a111a",
                        "output" => "1a1",
                    ],
                ]
            ],
            ["name" => "a we b sanlaryň jemini tapmagyň algoritmini", "description" => "a we b sanlaryň jemini tapmagyň algoritmini programma usulynda ýazmaly.", "tests" => [ ["input" => "3 5", "output" => "8"], ["input" => "5 10", "output" => "15"], ["input" => "20 67", "output" => "87"] ] ],
            ["name" => "x we y sanlaryň tapawudyny tapmagyň", "description" => "x we y sanlaryň tapawudyny tapmagyň algoritmini programma usulynda ýazmaly.", "tests" => [ ["input" => "5 3", "output" => "2"], ["input" => "10 5", "output" => "5"], ["input" => "67 20", "output" => "47"] ] ],
            ["name" => "Gönüburçlugyň taraplary berlende, onuň", "description" => "Gönüburçlugyň taraplary berlende, onuň perimetrini we meýdanyny tapmagyň algoritmini programma usulynda ýazmaly", "tests" => [ ["input" => "2 4", "output" => "12"], ["input" => "6 9", "output" => "30"], ["input" => "10 55", "output" => "130"] ] ],
            ["name" => "a we b sanlaryň köpeltmek hasylyny tapmagyň", "description" => "a we b sanlaryň köpeltmek hasylyny tapmagyň algoritmini programma usulynda düzmeli", "tests" => [ ["input" => "7 8", "output" => "56"], ["input" => "3 6", "output" => "18"], ["input" => "10 5", "output" => "50"] ] ],
            ["name" => "a we b natural sanlar berlen. Eger a> b", "description" => "a we b natural sanlar berlen. Eger a> b bolsa, onda a sany olaryň jemi bilen çalşyrýan, b sany öňküligine galdyrýan, galan ýagdaýlarda b sany olaryň köpeltmek hasyly bilen çalşyrýan, a sany öňküligine galdyrýan algoritmi programma usulynda ýazmaly.", "tests" => [ ["input" => "4 1", "output" => "5 1"], ["input" => "4 8", "output" => "4 32"], ["input" => "5 6", "output" => "5 30"] ] ],
            ["name" => "a we b natural sanlar berlen. a­dan b san", "description" => "a we b natural sanlar berlen. a­dan b san aralykda ähli natural sanlaryň jemini tapmaklygyň algoritmini programma usulynda ýazmaly (a we b sanlaryň özüni hem goşmaly).", "tests" => [ ["input" => "3 8", "output" => "33"], ["input" => "1 9", "output" => "45"], ["input" => "10 14", "output" => "60"] ] ],
            ["name" => "Üç sany natural sanlaryň jemini tapmaklygyň", "description" => "Üç sany natural sanlaryň jemini tapmaklygyň algoritmini programma usulynda ýazyň.", "tests" => [ ["input" => "1 4 6", "output" => "11"], ["input" => "10 35 40", "output" => "85"], ["input" => "5 8 3", "output" => "16"] ] ],
            ["name" => "Iki sanyň orta arifmetiki bahasyny", "description" => "Iki sanyň orta arifmetiki bahasyny tapmaklygyň algoritmini programma usulynda ýazyň.", "tests" => [ ["input" => "5 9", "output" => "7"], ["input" => "10 6", "output" => "8"], ["input" => "50 30", "output" => "40"] ] ],
            ["name" => "Deňtaraply üçburçlugyň tarapy berlen bolsa,", "description" => "Deňtaraply üçburçlugyň tarapy berlen bolsa, onuň perimetrini tapmaklygyň algoritmini programma usulynda ýazyň.", "tests" => [ ["input" => "6", "output" => "18"], ["input" => "20", "output" => "60"], ["input" => "100", "output" => "300"] ] ],
            ["name" => "Kubuň gapyrgasy berlen bolsa, onuň göwrümini", "description" => "Kubuň gapyrgasy berlen bolsa, onuň göwrümini tapmaklygyň algoritmini programma usulynda ýazyň.", "tests" => [ ["input" => "3", "output" => "27"], ["input" => "5", "output" => "125"], ["input" => "10", "output" => "1000"] ] ],
            ["name" => "Iki sanyň ulusyny tapmaklygyň algoritmini", "description" => "Iki sanyň ulusyny tapmaklygyň algoritmini programma usulynda ýazyň.", "tests" => [ ["input" => "4 6", "output" => "6"], ["input" => "10 17", "output" => "17"], ["input" => "5 1", "output" => "5"] ] ],
            ["name" => "Üç sanyň kiçisini tapmagyň algoritmini", "description" => "Üç sanyň kiçisini tapmagyň algoritmini programma usulynda ýazyň.", "tests" => [ ["input" => "1 4 6", "output" => "1"], ["input" => "4 3 7", "output" => "3"], ["input" => "7 4 2", "output" => "2"] ] ],
            ["name" => "2­den 10­a çenli natural sanlaryň jemini", "description" => "2­den 10­a çenli natural sanlaryň jemini tapmaklygyň algoritmini programma usulynda ýazyň.", "tests" => [ ["input" => "", "output" => "54"], ["input" => "", "output" => ""], ["input" => "", "output" => ""] ] ],
            ["name" => "20­ä çenli natural sanlaryň köpeltmek", "description" => "20­ä çenli natural sanlaryň köpeltmek hasylyny tapmagyň algoritmini programma usulynda ýazyň.", "tests" => [ ["input" => "", "output" => "2.43290200817664E+18"], ["input" => "", "output" => ""], ["input" => "", "output" => ""] ] ],
            ["name" => "–3­den 3­e çenli ähli bitin sanlaryň jemini", "description" => "–3­den 3­e çenli ähli bitin sanlaryň jemini tapmagyň algoritmini programma usulynda ýazyň.", "tests" => [ ["input" => "", "output" => "0"], ["input" => "", "output" => ""], ["input" => "", "output" => ""] ] ],
            ["name" => "Türkmenistanyň Garaşsyzlyk gününiniň", "description" => "Türkmenistanyň Garaşsyzlyk gününiniň senesini ekrana çapa çykarýan programma düzmeli.", "tests" => [ ["input" => "", "output" => "27.10.1991ý."], ["input" => "", "output" => ""], ["input" => "", "output" => ""] ] ],
            ["name" => "Ulanyjy tarapyndan klawiaturadan girizilen", "description" => "Ulanyjy tarapyndan klawiaturadan girizilen sany ekrana çykarýan programma ýazmaly.", "tests" => [ ["input" => "5", "output" => "5"], ["input" => "10", "output" => "10"], ["input" => "160", "output" => "160"] ] ],
            ["name" => "Klawiaturadan girizilen sany 2-ä köpeldip,", "description" => "Klawiaturadan girizilen sany 2-ä köpeldip, netijesini çykarýan programma ýazmaly.", "tests" => [ ["input" => "5", "output" => "10"], ["input" => "45", "output" => "90"], ["input" => "160", "output" => "320"] ] ],
            ["name" => "Iki bitin sanyň jemini we tapawudyny", "description" => "Iki bitin sanyň jemini we tapawudyny hasaplap çykarýan programma ýazmaly.", "tests" => [ ["input" => "2 5", "output" => "7 -3"], ["input" => "7 4", "output" => "11 3"], ["input" => " 5 15", "output" => "20 -10"] ] ],
            ["name" => "Klawiaturadan girizilen bitin sany 5 esse", "description" => "Klawiaturadan girizilen bitin sany 5 esse köpeldip, ekrana çykarýan programma düzmeli.", "tests" => [ ["input" => "10", "output" => "50"], ["input" => "4", "output" => "20"], ["input" => "7", "output" => "35"] ] ],
            ["name" => "Klawiaturadan girizilen bitin sany 10 san", "description" => "Klawiaturadan girizilen bitin sany 10 san artdyryp, ekrana çykarýan programma düzmeli.", "tests" => [ ["input" => "3", "output" => "13"], ["input" => "47", "output" => "57"], ["input" => "60", "output" => "70"] ] ],
            ["name" => " Klawiaturadan girizilen bitin üç sany sanyň", "description" => " Klawiaturadan girizilen bitin üç sany sanyň jemini ekrana çykarýan programma düzmeli.", "tests" => [ ["input" => "5 8 2", "output" => "15"], ["input" => "6 3 9", "output" => "18"], ["input" => "15 3 2", "output" => "20"] ] ],
            ["name" => "Klawiaturadan girizilen iki sany bitin sanyň", "description" => "Klawiaturadan girizilen iki sany bitin sanyň köpeltmek hasylyny ekrana çykarýan programma düzmeli.", "tests" => [ ["input" => "3 7", "output" => "21"], ["input" => "5 9", "output" => "45"], ["input" => "3 4", "output" => "12"] ] ],
            ["name" => "Berlen sany ilki 2 esse köpelýän, soňra 1", "description" => "Berlen sany ilki 2 esse köpelýän, soňra 1 birlik artýan programma ýazmaly.", "tests" => [ ["input" => "5", "output" => "10 11 "], ["input" => "10", "output" => "20 21"], ["input" => "3", "output" => "6 7"] ] ],
            ["name" => "k:=1+2; s:=2*k; t:=6– s amallar ýerine", "description" => "k:=1+2; s:=2*k; t:=6– s amallar ýerine ýetirilenden soň, t üýtgeýäne nähili san baha geçiriler?", "tests" => [ ["input" => "", "output" => "0"], ["input" => "", "output" => ""], ["input" => "", "output" => ""] ] ],
            ["name" => "Programmanyň aşakdaky parçalary ýerine", "description" => "Programmanyň aşakdaky parçalary ýerine ýetirilende, näme alnar?
a) a:=100; a:=10*a+1; writeln (a);
b) a:=100; a:=–a; writeln (a);
ç) a:=10; b:=25; a:=b–a; b:=a–b; writeln (a,' ',b).", "tests" => [ ["input" => "", "output" => "1001 -100 15 -5"], ["input" => "", "output" => ""], ["input" => "", "output" => ""] ] ],
            ["name" => "a-ny b bölmekde emele gelen bitin bölegi we", "description" => "a-ny b bölmekde emele gelen bitin bölegi we galyndyny çykarýan programma ýazmaly.", "tests" => [ ["input" => "13 5", "output" => "2 3"], ["input" => "16 7", "output" => "2 2"], ["input" => "20 3", "output" => "6 2"] ] ],
            ["name" => "2 sany hakyky san berlen. Olaryň orta", "description" => "2 sany hakyky san berlen. Olaryň orta arifmetik bahasyny, jemini, tapawudyny we köpeltmek hasylyny hasaplaýan programma ýazmaly.", "tests" => [ ["input" => "1.5 8.9", "output" => "5.2 10.4 -7.4 13.35 "], ["input" => "8.6 3.8", "output" => "6.2 12.4 4.8 32.68 "], ["input" => "1.2 5.3", "output" => "3.25 6.5 -4.1 6.36"] ] ],
            ["name" => "x üýtgeýän ululyk üçbelgili san. s üýtgeýän", "description" => "x üýtgeýän ululyk üçbelgili san. s üýtgeýän ululykda bu sanyň sifrleriniň jemini ýerleşdirýän programma ýazmaly.", "tests" => [ ["input" => "365", "output" => "14"], ["input" => "947", "output" => "20"], ["input" => "691", "output" => "16"] ] ],
            ["name" => "a hakyky üýtgeýäni b hakyky üýtgeýäne bölýän", "description" => "a hakyky üýtgeýäni b hakyky üýtgeýäne bölýän programmany ýazmaly.", "tests" => [ ["input" => "15.5 3.2", "output" => "4.84375"], ["input" => "24.6 6.4", "output" => "3.84375"], ["input" => "81.9 9.1", "output" => "9"] ] ],
            ["name" => "x hakyky san berlen. x sany iň golaý bitin", "description" => "x hakyky san berlen. x sany iň golaý bitin sana çenli tegelekleýän we netijäni ekrana çykarýan programma ýazmaly.", "tests" => [ ["input" => "6.7", "output" => "7"], ["input" => "5.4", "output" => "5"], ["input" => "12.9", "output" => "13"] ] ],
            ["name" => "x hakyky san berlen. x sanyň bitin bölegini", "description" => "x hakyky san berlen. x sanyň bitin bölegini 2 esse kiçeldýän we ekrana hasaplamanyň netijesini çykarýan programma ýazmaly.", "tests" => [ ["input" => "4.5", "output" => "2"], ["input" => "9.8", "output" => "4.5"], ["input" => "90.8", "output" => "45"] ] ],
            ["name" => "Bitin san berlen. Bu sany 2 esse kiçeldýän", "description" => "Bitin san berlen. Bu sany 2 esse kiçeldýän we ekrana hasaplamanyň netijesini çykarýan programma ýazmaly.", "tests" => [ ["input" => "9", "output" => "4.5"], ["input" => "10", "output" => "5"], ["input" => "4", "output" => "2"] ] ],
            ["name" => "c bitin san berlen. c sany 5-e bölmekden", "description" => "c bitin san berlen. c sany 5-e bölmekden ýeten paýy kwadrata göterýän we netijäni ekrana çykarýan programma ýazmaly.", "tests" => [ ["input" => "10", "output" => "4"], ["input" => "30", "output" => "36"], ["input" => "25", "output" => "25"] ] ],
            ["name" => "c hakyky san berlen. c sany 10-a bölmekden", "description" => "c hakyky san berlen. c sany 10-a bölmekden galan galyndyny kwadrata göterýän we netijäni ekrana çykarýan programma ýazmaly.", "tests" => [ ["input" => "2.8", "output" => "784"], ["input" => "4.1", "output" => "1681"], ["input" => "3.7", "output" => "1369"] ] ],
            ["name" => "Berlen üç belgili bitin sanyň sifrleriniň", "description" => "Berlen üç belgili bitin sanyň sifrleriniň jemini we köpeltmek hasylyny hasaplaýan, netijesini ekrana çykarýan programma ýazmaly.", "tests" => [ ["input" => "472", "output" => "13 56"], ["input" => "123", "output" => "6 6"], ["input" => "981", "output" => "18 72"] ] ],
            ["name" => "10-dan uly käbir natural san berlen. Onuň", "description" => "10-dan uly käbir natural san berlen. Onuň soňky sifrini ekrana çykarýan programma ýazmaly.", "tests" => [ ["input" => "1974", "output" => "4"], ["input" => "367", "output" => "7"], ["input" => "45", "output" => "5"] ] ],
            ["name" => "Abdy 1 manat 20 teňňeden n sany buzgaýmak we", "description" => "Abdy 1 manat 20 teňňeden n sany buzgaýmak we 80 teňňeden k sany şokolad satyn aldy. Abdy näçe manat harçlapdyr?", "tests" => [ ["input" => "6 12", "output" => "16.80"], ["input" => "2 5", "output" => "6.40"], ["input" => "1 15", "output" => "13.20"] ] ],
            ["name" => "A şäherden B şähere çenli aralyk s km. Otly", "description" => "A şäherden B şähere çenli aralyk s km. Otly bu aralygy t sagatda geçdi. Otly nähili tizlik bilen bu aralygy geçipdir (s we t – bitin sanlar)?", "tests" => [ ["input" => "160 2", "output" => "80.00"], ["input" => "200 4", "output" => "50.00"], ["input" => "250 4", "output" => "62.50"] ] ],
            ["name" => "Hakyky san berlen. Bu sanyň bitin bölegini", "description" => "Hakyky san berlen. Bu sanyň bitin bölegini üçünji derejä göterýän we netijesini ekrana çykarýan programma ýazmaly.", "tests" => [ ["input" => "4.6", "output" => "64"], ["input" => "3.9", "output" => "27"], ["input" => "9.9", "output" => "729"] ] ],
            ["name" => "Ikibelgili bitin san berlen. Onuň birinji", "description" => "Ikibelgili bitin san berlen. Onuň birinji sifrini ekrana çykarýan programma ýazmaly.", "tests" => [ ["input" => "45", "output" => "4"], ["input" => "90", "output" => "9"], ["input" => "13", "output" => "1"] ] ],
            ["name" => "Üçbelgili bitin san berlen. Bu sanyň ilki", "description" => "Üçbelgili bitin san berlen. Bu sanyň ilki soňky sifrini, soňra onuň kwadratyny ekrana çykarýan programma ýazmaly.", "tests" => [ ["input" => "567", "output" => "7 49"], ["input" => "396", "output" => "6 36"], ["input" => "123", "output" => "3 9"] ] ],
            ["name" => "Üç dostuň boýlary hakynda maglumat berlen.", "description" => "Üç dostuň boýlary hakynda maglumat berlen. Olaryň ortanjysynyň boýuny kesgitleýän we netijesini ekrana çykarýan programma ýazmaly.", "tests" => [ ["input" => "1.60 1.80 1.50 ", "output" => "1.50"], ["input" => "1.20 1.80 1.81", "output" => "1.80"], ["input" => "1.80 2.10 1.75", "output" => "1.80"] ] ],
            ["name" => "«3 * 5 = näçe bolýar?» diýen soragyň", "description" => "«3 * 5 = näçe bolýar?» diýen soragyň jogabyny ulanyjydan talap edýän, onuň girizen bahasyny 15 san bilen deňeşdirýän we degişlilikde «Dogry» ýa-da «Nädogry» habary ekrana çykarýan programmany düzmeli.", "tests" => [ ["input" => "25", "output" => "Nädogry"], ["input" => "15", "output" => "Dogry"], ["input" => "10", "output" => "Nädogry"] ] ],
            ["name" => "Girizilen bitin sanyň ikibelgili ýa-da", "description" => "Girizilen bitin sanyň ikibelgili ýa-da ikibelgili däldigini kesgitleýän we ekrana degişli: «San ikibelgili» ýa-da «San ikibelgili däl» habary çykarýan programmany düzmeli.", "tests" => [ ["input" => "27", "output" => "San ikibelgili"], ["input" => "1974", "output" => "San ikibelgili däl"], ["input" => "1", "output" => "San ikibelgili däl"] ] ],
            ["name" => "«27 * 6 = näçe bolýar?» diýen soragyň", "description" => "«27 * 6 = näçe bolýar?» diýen soragyň jogabyny ulanyjydan talap edýän, degişlilikde, «Dogry» ýa-da «Nä- dogry» habary ekrana çykarýan programmany düzmeli", "tests" => [ ["input" => "150", "output" => "Nädogry"], ["input" => "19", "output" => "Nädogry"], ["input" => "162", "output" => "Dogry"] ] ],
            ["name" => "Berlen bitin sanyň täkdigini kesgitleýän we", "description" => "Berlen bitin sanyň täkdigini kesgitleýän we degişlilikde, «Hawa» ýa-da «Ýok» habary ekrana çykarýan programmany düzmeli.", "tests" => [ ["input" => "5", "output" => "Hawa"], ["input" => "10", "output" => "Ýok"], ["input" => "3", "output" => "Hawa"] ] ],
            ["name" => "Eger girizilen san otrisatel bolsa, onda ony", "description" => "Eger girizilen san otrisatel bolsa, onda ony kwadrata göterýän we netijäni çapa çykarýan programma düzmeli.", "tests" => [ ["input" => "-5", "output" => "25"], ["input" => "-9", "output" => "81"], ["input" => "6", "output" => ""] ] ],
            ["name" => "Girizilen bitin sanyň üçbelgili ýa-da", "description" => "Girizilen bitin sanyň üçbelgili ýa-da üçbelgili däldigini kesgitleýän we ekrana degişli: «San üçbelgili» ýa-da «San üçbelgili däl» habary çykarýan programmany düzmeli.", "tests" => [ ["input" => "456", "output" => "San üçbelgili"], ["input" => "1989", "output" => "San üçbelgili däl"], ["input" => "196", "output" => "San üçbelgili"] ] ],
            ["name" => "Ogulnur we Gurbansoltan öz baglaryndan n", "description" => "Ogulnur we Gurbansoltan öz baglaryndan n kilogram erik ýygdylar. Şonuň a kilogramyny Ogulnur ýygdy. Gyzlaryň haýsysynyň köp erik ýygandygyny we beýlekisinden näçeräk köp ýygmagy başarandygyny kesgitleýän programma düzmeli.", "tests" => [ ["input" => "30 14", "output" => "Gurbansoltan 2"], ["input" => "10 9", "output" => "Ogulnur 8"], ["input" => "5 1", "output" => "Gurbansoltan 3"] ] ],
            ["name" => "Egerde berlen bitin san jübüt bolsa, onda", "description" => "Eger-de berlen bitin san jübüt bolsa, onda ony 2-ä bitinleýin bölmekde emele gelen netijäni çapa çykarýan programma düzmeli.", "tests" => [ ["input" => "18", "output" => "9"], ["input" => "11", "output" => "11"], ["input" => "10", "output" => "5"] ] ],
            ["name" => "Eger-de berlen iki bitin sanyň her biri", "description" => "Eger-de berlen iki bitin sanyň her biri noldan tapawutly bolsa, onda olaryň orta arifmetiki bahasyny, garşylykly ýagdaýda 0 bahany çapa çykarýan programma düzmeli.", "tests" => [ ["input" => "7 8", "output" => "7.5"], ["input" => "0 -9", "output" => "0"], ["input" => "56 0", "output" => "0"] ] ],
            ["name" => "Eger-de berlen bitin san jübüt bolsa, onda", "description" => "Eger-de berlen bitin san jübüt bolsa, onda ony iki esse ulaltmaly, emele gelen netijäni çapa çykarýan programma düzmeli.", "tests" => [ ["input" => "8", "output" => "16"], ["input" => "10", "output" => "20"], ["input" => "3", "output" => "0"] ] ],
            ["name" => "Eger adamyň ýaşy 6-dan 18 aralykda bolsa,", "description" => "Eger adamyň ýaşy 6-dan 18 aralykda bolsa, onuň okuwçydygyny kesgitleýän, degişlilikde «Hawa, okuwçy» ýa-da «Ýok, okuwçy däl» ýazgylary çapa çykarýan programma düzmeli.", "tests" => [ ["input" => "15", "output" => "Hawa, okuwçy"], ["input" => "4", "output" => "Ýok, okuwçy däl"], ["input" => "17", "output" => "Hawa, okuwçy"] ] ],
            ["name" => "Berlen bitin sanyň 3-e galyndysyz", "description" => "Berlen bitin sanyň 3-e galyndysyz bölünýändigini kesgitleýän programma düzmeli.", "tests" => [ ["input" => "9", "output" => "3"], ["input" => "5", "output" => "0"], ["input" => "27", "output" => "9"] ] ],
            ["name" => "Berlen nola deň bolmadyk bitin sanyň", "description" => "Berlen nola deň bolmadyk bitin sanyň položiteldigini ýa-da otrisateldigini kesgitleýän we eger-de položitel bolsa, onda bu sany iki esse kiçeldýän, garşylykly ýagdaýda kwadrata göterýän, netijäni çapa çykarýan programmany düzmeli.", "tests" => [ ["input" => "18", "output" => "9"], ["input" => "-4", "output" => "16"], ["input" => "-3", "output" => "9"] ] ],
            ["name" => "Eger berlen bitin san ikibelgili bolsa, onda", "description" => "Eger berlen bitin san ikibelgili bolsa, onda onluklarda duran birinji sifri we birliklerde duran ikinji sifri, garşylykly ýagdaýda «sifrleri tapyp bilmeýärin» diýen habary çapa çykarýan programma düzmeli.", "tests" => [ ["input" => "27", "output" => "2 7"], ["input" => "2000", "output" => "sifrleri tapyp bilmeýärin"], ["input" => "45", "output" => "4 5"] ] ],
            ["name" => "Berlen üç sany bitin sanyň içinden otrisatel", "description" => "Berlen üç sany bitin sanyň içinden otrisatel dällerini çapa çykarýan programma düzmeli.", "tests" => [ ["input" => "6 7 -8", "output" => "-8"], ["input" => "-9 -8 -4", "output" => "-9 -8 -4"], ["input" => "-7 6 8", "output" => "-7"] ] ],
            ["name" => "Berlen üçburçlugyň taraplarynyň uzynlyklary", "description" => "Berlen üçburçlugyň taraplarynyň uzynlyklary boýunça onuň deňtaraplydygyny hem-de deňýanlydygyny ýa-da dürli taraplydygyny kesgitleýän we degişli ýazgyny çapa çykarýan programma düzmeli.", "tests" => [ ["input" => "8 9 5", "output" => "Dürli taraply"], ["input" => "8 8 9", "output" => "Deňýanly"], ["input" => "5 5 5", "output" => "Deňtaraply"] ] ],
            ["name" => "Berlen aýyň san belgisi boýunça onuň degişli", "description" => "Berlen aýyň san belgisi boýunça onuň degişli paslynyň adyny çapa çykarýan programma düzmeli.", "tests" => [ ["input" => "2", "output" => "Gyş"], ["input" => "5", "output" => "Ýaz"], ["input" => "8", "output" => "Tomus"] ] ],
            ["name" => "Berlen ýylyň uzyn ýyl ýa-da adaty ýyldygyny", "description" => "Berlen ýylyň uzyn ýyl ýa-da adaty ýyldygyny kesgitleýän programma düzmeli.", "tests" => [ ["input" => "1974", "output" => "Adaty ýyl"], ["input" => "2000", "output" => "Uzyn ýyl"], ["input" => "2020", "output" => "Uzyn ýyl"] ] ],
            ["name" => "Berlen dürli üç bitin sanyň kiçisini çapa", "description" => "Berlen dürli üç bitin sanyň kiçisini çapa çykarýan programma düzmeli.", "tests" => [ ["input" => "7 9 4", "output" => "4"], ["input" => " 5 2 8", "output" => "2"], ["input" => "1 7 4", "output" => "1"] ] ],
            ["name" => "Berlen günüň san belgisi boýunça onuň", "description" => "Berlen günüň san belgisi boýunça onuň hepdäniň haýsy gününe degişlidigini çapa çykarýan programma düzmeli.", "tests" => [ ["input" => "3", "output" => "Çarşenbe"], ["input" => "7", "output" => "Ýekşenbe"], ["input" => "5", "output" => "Anna"] ] ],
            ["name" => "a, b, с üç san berlen. a < b < с şerti", "description" => "a, b, с üç san berlen. a < b < с şerti barlamaly. Jogap «Hawa» ýa-da «Ýok» görnüşde alnar ýaly, programma düzmeli.", "tests" => [ ["input" => "1 4 7", "output" => "Hawa"], ["input" => "1 7 5", "output" => "Ýok"], ["input" => "4 7 9", "output" => "Hawa"] ] ],
            ["name" => "Klawiaturadan girizilen üç sany hakyky sanyň", "description" => "Klawiaturadan girizilen üç sany hakyky sanyň jemi položitel bolsa «Hawa», otrisatel bolsa «Ýok» ýazgyny çapa çykarýan programma düzmeli.", "tests" => [ ["input" => "4.5 6.8 9.8", "output" => "Hawa"], ["input" => "-8.9 -1.1 15", "output" => "Hawa"], ["input" => "-9.5 -3.4 2", "output" => "Ýok"] ] ],
            ["name" => "Klawiaturadan girizilen bäş sany bitin sanyň", "description" => "Klawiaturadan girizilen bäş sany bitin sanyň iň ulusyny tapýan we netijäni çapa çykarýan programma düzmeli.", "tests" => [ ["input" => "7 8 9 12 4", "output" => "12"], ["input" => "-1 9 -109 67 4", "output" => "67"], ["input" => "1 8 5 -9 5", "output" => "8"] ] ],
            ["name" => "10-dan 20-ä çenli bitin sanlaryň", "description" => "10-dan 20-ä çenli bitin sanlaryň kwadratlaryny çapa çykarmagyň programmasyny ýazyň.", "tests" => [ ["input" => "", "output" => "2585"], ["input" => "", "output" => ""], ["input" => "", "output" => ""] ] ],
            ["name" => "2-den 100-e çenli bitin sanlaryň jemini", "description" => "2-den 100-e çenli bitin sanlaryň jemini hasaplamagyň programmasyny ýazyň.", "tests" => [ ["input" => "", "output" => "5049"], ["input" => "", "output" => ""], ["input" => "", "output" => ""] ] ],
            ["name" => "1-den n-e çenli bitin sanlaryň jemini", "description" => "1-den n-e çenli bitin sanlaryň jemini hasaplamagyň programmasyny ýazyň.", "tests" => [ ["input" => "3", "output" => "6"], ["input" => "10", "output" => "55"], ["input" => "257", "output" => "33153"] ] ],
            ["name" => "1-den n-e çenli bitin sanlaryň köpeltmek", "description" => "1-den n-e çenli bitin sanlaryň köpeltmek hasylyny hasaplamagyň programmasyny ýazyň.", "tests" => [ ["input" => "10", "output" => "3628800"], ["input" => "4", "output" => "24"], ["input" => "7", "output" => "5040"] ] ],
            ["name" => "«Meniň Watanym – Eziz Türkmenistan!» ýazgyny", "description" => "«Meniň Watanym – Eziz Türkmenistan!» ýazgyny 5 gezek gaýtalap çapa çykarýan programma düzmeli.", "tests" => [ ["input" => "", "output" => "Meniň Watanym – Eziz Türkmenistan!
Meniň Watanym – Eziz Türkmenistan!
Meniň Watanym – Eziz Türkmenistan!
Meniň Watanym – Eziz Türkmenistan!
Meniň Watanym – Eziz Türkmenistan!"], ["input" => "", "output" => ""], ["input" => "", "output" => ""] ] ],
            ["name" => "Ilkinji 10 sany natural sanyň jemini tapmaly", "description" => "Ilkinji 10 sany natural sanyň jemini tapmaly we netijesini çapa çykarýan programma düzmeli.", "tests" => [ ["input" => "", "output" => "55"], ["input" => "", "output" => ""], ["input" => "", "output" => ""] ] ],
            ["name" => "Ilkinji 10 sany natural sanlary ters", "description" => "Ilkinji 10 sany natural sanlary ters tertipde çapa çykarýan programma düzmeli.", "tests" => [ ["input" => "", "output" => "10 9 8 7 6 5 4 3 2 1"], ["input" => "", "output" => ""], ["input" => "", "output" => ""] ] ],
            ["name" => "Ilkinji 5 sany täk natural sanlary çapa", "description" => "Ilkinji 5 sany täk natural sanlary çapa çykarýan programma düzmeli.", "tests" => [ ["input" => "", "output" => "1 3 5 7 9"], ["input" => "", "output" => ""], ["input" => "", "output" => ""] ] ],
            ["name" => "5-den 9 aralykdaky natural sanlary çapa", "description" => "5-den 9 aralykdaky natural sanlary çapa çykarýan programma düzmeli.", "tests" => [ ["input" => "", "output" => "5 6 7 8 9"], ["input" => "", "output" => ""], ["input" => "", "output" => ""] ] ],
            ["name" => "«Bilimli nesil – kuwwatly Watan!» ýazgyny 7", "description" => "«Bilimli nesil – kuwwatly Watan!» ýazgyny 7 gezek gaýtalap çapa çykarýan programma düzmeli", "tests" => [ ["input" => "", "output" => "Bilimli nesil – kuwwatly Watan!
Bilimli nesil – kuwwatly Watan!
Bilimli nesil – kuwwatly Watan!
Bilimli nesil – kuwwatly Watan!
Bilimli nesil – kuwwatly Watan!
Bilimli nesil – kuwwatly Watan!
Bilimli nesil – kuwwatly Watan!"], ["input" => "", "output" => ""], ["input" => "", "output" => ""] ] ],
            ["name" => "10-dan 15-e çenli natural sanlaryň jemini", "description" => "10-dan 15-e çenli natural sanlaryň jemini hasaplaýan we çapa çykarýan programma düzmeli.", "tests" => [ ["input" => "", "output" => "75"], ["input" => "", "output" => ""], ["input" => "", "output" => ""] ] ],
            ["name" => "Ilkinji n sany natural sanlaryň jemini çapa", "description" => "Ilkinji n sany natural sanlaryň jemini çapa çykarýan programma düzmeli.", "tests" => [ ["input" => "10", "output" => "55"], ["input" => "7", "output" => "28"], ["input" => "3", "output" => "6"] ] ],
            ["name" => "Berlen n natural sanyň sifrleriniň jemini", "description" => "Berlen n natural sanyň sifrleriniň jemini tapýan we netijäni çapa çykarýan programma düzmeli.", "tests" => [ ["input" => "347", "output" => "14"], ["input" => "23", "output" => "5"], ["input" => "1234", "output" => "10"] ] ],
            ["name" => "Ilkinji n natural sanlaryň köpeltmek", "description" => "Ilkinji n natural sanlaryň köpeltmek hasylyny tapýan we netijäni çapa çykarýan programma düzmeli.", "tests" => [ ["input" => "6", "output" => "720"], ["input" => "10", "output" => "3628800"], ["input" => "4", "output" => "24"] ] ],
            ["name" => "5-den 10-a çenli ähli natural sanlaryň", "description" => "5-den 10-a çenli ähli natural sanlaryň köpeltmek hasylyny tapýan we netijäni çapa çykarýan programma düzmeli.", "tests" => [ ["input" => "", "output" => "151200"], ["input" => "", "output" => ""], ["input" => "", "output" => ""] ] ],
            ["name" => "n natural sanyň kubuny", "description" => "n natural sanyň kubuny tapmaly.", "tests" => [ ["input" => "3", "output" => "27"], ["input" => "2", "output" => "8"], ["input" => "5", "output" => "125"] ] ],
            ["name" => "Berlen natural sanyň ähli bölüjilerini", "description" => "Berlen natural sanyň ähli bölüjilerini (özünden we birden başgalaryny) tapýan we çapa çykarýan programma düzmeli.", "tests" => [ ["input" => "18", "output" => "2 3 6 9"], ["input" => "27", "output" => "3 9"], ["input" => "6", "output" => "2 3"] ] ],
            ["name" => "Banka maýalaşdyrma görnüşinde ýyllyk 10%", "description" => "Banka maýalaşdyrma görnüşinde ýyllyk 10% bilen goýlan 2000 manadyň ýene näçe ýyldan 2 esse köpeljekdigini kesgitleýän we çapa çykarýan programma düzmeli.", "tests" => [ ["input" => "", "output" => "8"], ["input" => "", "output" => ""], ["input" => "", "output" => ""] ] ],
        ];
        foreach ($problems as $item) {
            $problem = new Problem();
            $problem->setName($item['name']);
            $problem->setDescription($item['description']);
            $manager->persist($problem);
            $tmp = new ArrayCollection();
            foreach ($item["tests"] as $item2) {
                if (empty($item2["input"]) || empty($item2["output"])) continue;
                $test = new ProblemTest();
                $test->setInput($item2["input"]);
                $test->setOutput($item2["output"]);
                $test->setProblem($problem);
                $manager->persist($test);
            }
        }
        $manager->flush();
    }
}