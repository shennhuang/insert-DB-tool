<?php

require dirname(__DIR__) . '/insertDB/NccConfig.php';
require dirname(__DIR__) . '/insertDB/vendor/autoload.php';

use MongoDB\Client as Mongo;

$insertData = json_decode(file_get_contents('insertData.json'), true);
$platform = $insertData['platform'];
$mongo = getMongo($platform);
$collection = $mongo->selectCollection('mdb0g00009', 'resume_score');

$insertDatas = packData($insertData['data']);
$res = $collection->insertMany($insertDatas);
vaR_dump($res);

function getMongo($platform)
{
    $config = new NccConfig;
    $config = $config->loadNccWspdttConfig();
    $mongoDB = $config['database']['mongoDB'][$platform];

    $connString = 'mongodb://';
    $connString .= $mongoDB['username'];
    $connString .= ':' . $mongoDB['password'];
    $connString .= '@' . $mongoDB['host'];
    $connString .= ':' . $mongoDB['port'];
    $connString .= '/' . $mongoDB['dbname'];
    try {
        $option = ['connect' => true];
        return new Mongo($connString, $option);
    } catch(Exception $e) {
        throw new Exception('NEW MONGO ERROR!', 500);
    }
}

function packData($datas)
{
    $res = [];
    foreach ($datas as $data) {
        $idno = $data['idno'];
        $jobno = $data['jobno'];
        $version = $data['version'];
        $score = $data['score'];
        
        $temp = [
            "id_no" => (int)$idno,
            "jobno" => (int)$jobno,
            "version_no" => (int)$version,
            "score" => $score,
            "z_score" => 0,
            "w" => -0.1879607,
            "insertion_time" => "2020-04-29T02:16:03.610Z",
            "skill_detail" => [
                "skill" => [
                    "exact_match" => [],
                    "not_match" => [ 
                        "電話客服", 
                        "資訊科技", 
                        "產品推廣", 
                        "電銷", 
                        "電話行銷", 
                        "業務銷售", 
                        "顧客關係維護"
                    ],
                    "relative" => [],
                    "score" => 0.710249364376068
                ],
                "tool" => [
                    "exact_match" => [],
                    "not_match" => [ 
                        "excel", 
                        "word", 
                        "中文打字20~50", 
                        "outlook"
                    ],
                    "relative" => [],
                    "score" => [ 
                        0.0
                    ]
                ],
                "language" => [
                    "exact_match" => [],
                    "not_match" => [],
                    "relative" => [],
                    "score" => [ 
                        0.0
                    ]
                ],
                "locallan" => [
                    "exact_match" => [],
                    "not_match" => [ 
                        [ 
                            "1-L:1"
                        ]
                    ],
                    "relative" => [],
                    "score" => [ 
                        0.0
                    ]
                ],
                "cert" => [
                    "exact_match" => [],
                    "not_match" => [],
                    "relative" => [],
                    "score" => [ 
                        0.0
                    ]
                ]
            ],
            "exp_detail" => [
                "exp_job_hist" => [
                    "exact_match" => [],
                    "relative" => [],
                    "score" => [ 
                        0.0
                    ]
                ],
                "industry" => [
                    "exact_match" => [],
                    "relative" => [],
                    "score" => [ 
                        0.0
                    ]
                ],
                "company" => [
                    "exact_match" => [],
                    "relative" => [],
                    "score" => [ 
                        0.0
                    ]
                ]
            ],
            "education_detail" => [
                "jobEduDegree" => [
                    "exact_match" => [ 
                        "大學"
                    ],
                    "relative" => [],
                    "not_match" => [],
                    "score" => [ 
                        1.0
                    ]
                ],
                "major" => [
                    "exact_match" => [],
                    "relative" => [],
                    "not_match" => [],
                    "score" => [ 
                        0.0
                    ]
                ]
            ],
            "expectation_detail" => [
                "area" => [
                    "exact_match" => [],
                    "relative" => [ 
                        "新北市土城區", 
                        "新北市中和區", 
                        "新北市板橋區", 
                        "新北市永和區", 
                        "台北市萬華區"
                    ],
                    "score" => 0.33766958117485,
                    "not_match" => []
                ],
                "workFeature" => [
                    "exact_match" => [ 
                        "全職"
                    ],
                    "relative" => [],
                    "score" => 1.0,
                    "not_match" => []
                ],
                "jobcategory" => [
                    "exact_match" => [ 
                        "2005001004"
                    ],
                    "relative" => [ 
                        "2006002003", 
                        "2002001009", 
                        "2002001003", 
                        "2001002002"
                    ],
                    "score" => 0.299837589263916,
                    "not_match" => []
                ],
                "jobTitle" => [
                    "exact_match" => [],
                    "relative" => [],
                    "score" => -0.0272113978862762,
                    "not_match" => [ 
                        "電話行銷與服務(台北)-【營運發展處】"
                    ]
                ],
                "industry" => [
                    "exact_match" => [],
                    "relative" => [],
                    "score" => [ 
                        0.0
                    ],
                    "not_match" => [ 
                        "1001001003"
                    ]
                ]
            ]
        ];

        $res[] = $temp;
    }


    return $res;
}