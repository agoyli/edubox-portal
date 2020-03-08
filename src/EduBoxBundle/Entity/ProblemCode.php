<?php

namespace EduBoxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProblemCode
 *
 * @ORM\Table(name="problem_code")
 * @ORM\Entity(repositoryClass="EduBoxBundle\Repository\ProblemCodeRepository")
 */
class ProblemCode
{
    public static $languages = [
        1 => "markup",
        2 => "css",
        3 => "clike",
        4 => "javascript",
        5 => "abap",
        6 => "abnf",
        7 => "actionscript",
        8 => "ada",
        9 => "antlr4",
        10 => "apacheconf",
        11 => "apl",
        12 => "applescript",
        13 => "aql",
        14 => "arduino",
        15 => "arff",
        16 => "asciidoc",
        17 => "asm6502",
        18 => "aspnet",
        19 => "autohotkey",
        20 => "autoit",
        21 => "bash",
        22 => "basic",
        23 => "batch",
        24 => "bbcode",
        25 => "bison",
        26 => "bnf",
        27 => "brainfuck",
        28 => "brightscript",
        29 => "bro",
        30 => "c",
        31 => "concurnas",
        32 => "csharp",
        33 => "cpp",
        34 => "cil",
        35 => "coffeescript",
        36 => "cmake",
        37 => "clojure",
        38 => "crystal",
        39 => "csp",
        40 => "css-extras",
        41 => "d",
        42 => "dart",
        43 => "diff",
        44 => "django",
        45 => "dns-zone-file",
        46 => "docker",
        47 => "ebnf",
        48 => "eiffel",
        49 => "ejs",
        50 => "elixir",
        51 => "elm",
        52 => "etlua",
        53 => "erb",
        54 => "erlang",
        55 => "fsharp",
        56 => "factor",
        57 => "firestore-security-rules",
        58 => "flow",
        59 => "fortran",
        60 => "ftl",
        61 => "gcode",
        62 => "gdscript",
        63 => "gedcom",
        64 => "gherkin",
        65 => "git",
        66 => "glsl",
        67 => "gml",
        68 => "go",
        69 => "graphql",
        70 => "groovy",
        71 => "haml",
        72 => "handlebars",
        73 => "haskell",
        74 => "haxe",
        75 => "hcl",
        76 => "http",
        77 => "hpkp",
        78 => "hsts",
        79 => "ichigojam",
        80 => "icon",
        81 => "inform7",
        82 => "ini",
        83 => "io",
        84 => "j",
        85 => "java",
        86 => "javadoc",
        87 => "javadoclike",
        88 => "javastacktrace",
        89 => "jolie",
        90 => "jq",
        91 => "jsdoc",
        92 => "js-extras",
        93 => "js-templates",
        94 => "json",
        95 => "jsonp",
        96 => "json5",
        97 => "julia",
        98 => "keyman",
        99 => "kotlin",
        100 => "latex",
        101 => "latte",
        102 => "less",
        103 => "lilypond",
        104 => "liquid",
        105 => "lisp",
        106 => "livescript",
        107 => "lolcode",
        108 => "lua",
        109 => "makefile",
        110 => "markdown",
        111 => "markup-templating",
        112 => "matlab",
        113 => "mel",
        114 => "mizar",
        115 => "monkey",
        116 => "moonscript",
        117 => "n1ql",
        118 => "n4js",
        119 => "nand2tetris-hdl",
        120 => "nasm",
        121 => "neon",
        122 => "nginx",
        123 => "nim",
        124 => "nix",
        125 => "nsis",
        126 => "objectivec",
        127 => "ocaml",
        128 => "opencl",
        129 => "oz",
        130 => "parigp",
        131 => "parser",
        132 => "pascal",
        133 => "pascaligo",
        134 => "pcaxis",
        135 => "perl",
        136 => "php",
        137 => "phpdoc",
        138 => "php-extras",
        139 => "plsql",
        140 => "powershell",
        141 => "processing",
        142 => "prolog",
        143 => "properties",
        144 => "protobuf",
        145 => "pug",
        146 => "puppet",
        147 => "pure",
        148 => "python",
        149 => "q",
        150 => "qml",
        151 => "qore",
        152 => "r",
        153 => "jsx",
        154 => "tsx",
        155 => "renpy",
        156 => "reason",
        157 => "regex",
        158 => "rest",
        159 => "rip",
        160 => "roboconf",
        161 => "robotframework",
        162 => "ruby",
        163 => "rust",
        164 => "sas",
        165 => "sass",
        166 => "scss",
        167 => "scala",
        168 => "scheme",
        169 => "shell-session",
        170 => "smalltalk",
        171 => "smarty",
        172 => "solidity",
        173 => "solution-file",
        174 => "soy",
        175 => "sparql",
        176 => "splunk-spl",
        177 => "sqf",
        178 => "sql",
        179 => "stylus",
        180 => "swift",
        181 => "tap",
        182 => "tcl",
        183 => "textile",
        184 => "toml",
        185 => "tt2",
        186 => "turtle",
        187 => "twig",
        188 => "typescript",
        189 => "t4-cs",
        190 => "t4-vb",
        191 => "t4-templating",
        192 => "vala",
        193 => "vbnet",
        194 => "velocity",
        195 => "verilog",
        196 => "vhdl",
        197 => "vim",
        198 => "visual-basic",
        199 => "wasm",
        200 => "wiki",
        201 => "xeora",
        202 => "xojo",
        203 => "xquery",
        204 => "yaml",
        205 => "zig",
    ];

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="text")
     */
    private $code;

    /**
     * @var int
     *
     * @ORM\Column(name="languageId", type="integer")
     */
    private $languageId;

    /**
     * @var Problem
     *
     * @ORM\ManyToOne(targetEntity="EduBoxBundle\Entity\Problem", inversedBy="codes")
     */
    private $problem;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return ProblemCode
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set language
     *
     * @param integer $languageId
     *
     * @return ProblemCode
     */
    public function setLanguage($languageId)
    {
        $this->languageId = $languageId;

        return $this;
    }

    /**
     * Get languageId
     *
     * @return int
     */
    public function getLanguage()
    {
        return $this->languageId;
    }

    /**
     * Get languageId
     *
     * @return int
     */
    public function getLanguageName()
    {
        return isset(self::$languages[$this->languageId]) ? self::$languages[$this->languageId] : null;
    }

    /**
     * Set problem
     *
     * @param Problem $problem
     *
     * @return ProblemCode
     */
    public function setProblem($problem)
    {
        $this->problem = $problem;

        return $this;
    }

    /**
     * Get problem
     *
     * @return Problem
     */
    public function getProblem()
    {
        return $this->problem;
    }
}

