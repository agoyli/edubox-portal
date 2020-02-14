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

class EduBoxFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

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

        // Creating contexts
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
        // Create tags
        foreach ($tags as $key => $item) {
            $category = new Tag();
            $category->setEnabled(true);
            $category->setName($item["name"]);
            $category->setContext($item["context"]["context"]);
            $category->setSlug($key);
            $manager->persist($category);
        }
        $manager->flush();

        // Create users
        $users = [
            "admin" => [
                "password" => "admin",
                "roles" => ["ROLE_SUPER_ADMIN"],
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


        // Create authors
        $authors = [
            "1" => ["fullname" => "Gurbannazar Ezizow"],
            "2" => ["fullname" => "Çary Aşyrow"],
            "3" => ["fullname" => "Nurmyrat Saryhanow"],
            "4" => ["fullname" => "Kerim Gurbannepesow"],
            "5" => ["fullname" => "Baýmuhammet Garryýew"],
            "6" => ["fullname" => "Mämmet Seýidow"],
            "7" => ["fullname" => "Hydyr Derýaýew"],
            "8" => ["fullname" => "Gurbanaly Magrupy"],
            "9" => ["fullname" => "Ata Gowşudow"],
        ];
        foreach ($authors as $key => $item) {
            $author = new Author();
            $author->setFullName($item['fullname']);
            $author->setId($key);
            $manager->persist($author);
            $authors[$key]["author"] = $author;
        }
        $manager->flush();

        // Create books
        $books = [
            ["name" => "Saýlanan eserler", "year" => "1995", "pages" => "262", "author" => "1", "bookfile" => "media/pdf/1.pdf", "bookImage" => "media/image/book/1.png"],
            ["name" => "Göreş", "year" => "1986", "pages" => "220", "author" => "2", "bookfile" => "media/pdf/2.pdf", "bookImage" => "media/image/book/2.png"],
            ["name" => "Şükür bagşy", "year" => "1961", "pages" => "53", "author" => "3", "bookfile" => "media/pdf/3.pdf", "bookImage" => "media/image/book/3.png"],
            ["name" => "Oýlanma baýry", "year" => "1995", "pages" => "437", "author" => "4", "bookfile" => "media/pdf/4.pdf", "bookImage" => "media/image/book/4.png"],
            ["name" => "Magtymguly", "year" => "1959", "pages" => "204", "author" => "5", "bookfile" => "media/pdf/5.pdf", "bookImage" => "media/image/book/5.png"],
            ["name" => "Kesearkaç", "year" => "", "pages" => "539", "author" => "6", "bookfile" => "media/pdf/6.pdf", "bookImage" => "media/image/book/6.png"],
            ["name" => "Ykbal birinji tom", "year" => "", "pages" => "325", "author" => "7", "bookfile" => "media/pdf/7.pdf", "bookImage" => "media/image/book/7.png"],
            ["name" => "Magrupy", "year" => "1991", "pages" => "48", "author" => "8", "bookfile" => "media/pdf/8.pdf", "bookImage" => "media/image/book/8.png"],
            ["name" => "Perman", "year" => "1989", "pages" => "993", "author" => "9", "bookfile" => "media/pdf/9.pdf", "bookImage" => "media/image/book/9.png"],
        ];
        foreach ($books as $item)
        {
            $bookFile = new Media();
            $bookFile->setBinaryContent('/var/www/edx.pw.loc/web/uploads/'.$item['bookfile']);
            $bookFile->setContext('book');
            $bookFile->setCategory($contexts['book']['context']->category);
            $bookFile->setProviderName('sonata.media.provider.file');

            $bookImage = new Media();
            $bookImage->setBinaryContent('/var/www/edx.pw.loc/web/uploads/'.$item['bookImage']);
            $bookImage->setContext('book');
            $bookImage->setCategory($contexts['book']['context']->category);
            $bookImage->setProviderName('sonata.media.provider.image');

            $manager->persist($bookFile);
            $manager->persist($bookImage);

            $book = new Book();
            $book->setBookFile($bookFile);
            $book->setBookImage($bookImage);
            $book->setName($item["name"]);
            if ((int)$item["year"] > 0) $book->setYear((int)$item["year"]);
            $tmp = explode(',', $item['author']);
            $item['author'] = [];
            foreach ($tmp as $t) {
                $t = (int)trim($t);
                if ($t > 0) {
                    $item['author'][] = $authors[$t]["author"];
                }
            }
            $book->setAuthors(new ArrayCollection($item["author"]));
            $book->setPageCount((int)$item['pages']);

            $manager->persist($book);
        }
        $manager->flush();

        // Create resources
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
        ];
        foreach ($resources as $item) {
            $resource = new Resource();
            $resource->setName($item['name']);
            $resource->setContent($item['content']);
            $manager->persist($resource);
        }
        $manager->flush();


        // Create problems
        $problems = [
            [
                "name" => "Iki sany massiw",
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
            ]
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