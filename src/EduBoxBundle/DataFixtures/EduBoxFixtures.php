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


        // Create authors
        $authors = [
            "1" => ["fullname" => "Gurbannazar Ezizow"],
            "3" => ["fullname" => "Nurmyrat Saryhanow"],
            "4" => ["fullname" => "Kerim Gurbannepesow"],
            "8" => ["fullname" => "Gurbanaly Magrupy"],
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
            ["name" => "Saýlanan eserler", "year" => "1995", "pages" => "262", "author" => "1", "bookfile" => "uploads/pdf/1.pdf", "bookImage" => "uploads/image/book/1.png"],
            ["name" => "Şükür bagşy", "year" => "1961", "pages" => "53", "author" => "3", "bookfile" => "uploads/pdf/3.pdf", "bookImage" => "uploads/image/book/3.png"],
            ["name" => "Oýlanma baýry", "year" => "1995", "pages" => "437", "author" => "4", "bookfile" => "uploads/pdf/4.pdf", "bookImage" => "uploads/image/book/4.png"],
            ["name" => "Magrupy", "year" => "1991", "pages" => "48", "author" => "8", "bookfile" => "uploads/pdf/8.pdf", "bookImage" => "uploads/image/book/8.png"],
        ];
        foreach ($books as $item)
        {
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


        // Create problems
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