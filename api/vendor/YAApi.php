<?php 

    // $_SERVER['HTTP_HOST'] = 'yug-avto-expert.ru';
    use Bitrix\Main\Loader;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    Loader::includeModule("iblock");
    Loader::includeModule("cfile");
    Loader::IncludeModule('form');


    class YAApi {

        public static function Route() {

            $url = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $ar = explode('/', parse_url($url)['path']);

            return [
                'entity' => $ar['2'],
                'id' => $ar['3'],
                'data' => $_GET
            ];
	    }


        public static function apiGetOffers( $GET = [] ) {

            $res = [];

            $rs = CIBlockElement::GetList(
                [],
                [
                    'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
                    'ACTIVE' => 'Y',
                    // 'PROPERTY_EXTERNAL_CODE' => $GET['dealership']
                    '=PROPERTY_EXTERNAL_CODE' => explode(',', $GET['dealership'])
                ],
                false,
                false,
                ['ID', 'NAME', 'PROPERTY_EXTERNAL_CODE']
            );
            while ( $ob = $rs->GetNextElement() ) $d[] = $ob->GetFields()['ID'];

            $rs = CIBlockElement::GetList(
                ['ACTIVE_FROM' => 'DESC'],
                [
                    'IBLOCK_ID' => YApp::IBLOCK_OFFERS,
                    'ACTIVE' => 'Y',
                    '<=DATE_ACTIVE_TO ' => date('d.m.Y H:i:s'),
                    '=PROPERTY_DEALERSHIP' => $d
                ],
                false,
                ['nPageSize' => 9],
                ['ID', 'NAME', 'DETAIL_PAGE_URL', 'PREVIEW_PICTURE', 'ACTIVE_TO', 'PROPERTY_DEALERSHIP']
            );
            while ( $ob = $rs->GetNextElement() ) {
                
                $tmp = $ob->GetFields();
                $tmp['ACTIVE_TO'] = ( $tmp['ACTIVE_TO'] ) ? date('d.m.Y', strtotime($tmp['ACTIVE_TO'])) : false; 
                $tmp['PREVIEW_PICTURE'] = 'https://'.$_SERVER['HTTP_HOST'].CFile::GetPath($tmp['PREVIEW_PICTURE']);
                $tmp['DETAIL_PAGE_URL'] = 'https://'.$_SERVER['HTTP_HOST'].$tmp['DETAIL_PAGE_URL'];
                foreach( $tmp as $k => $i ) if ( mb_strripos($k, '~') !== false ) unset($tmp[$k]);

                $prop_s = CIBlockElement::GetProperty(
                    YApp::IBLOCK_OFFERS,
                    $tmp['ID'],
                    'sort', 'asc',
                    ['CODE' => 'TAG']
                );
                while( $prop_o = $prop_s->GetNext() ) {
                    $tmp['TAG'][] = $prop_o['VALUE_ENUM'];
                }

                $res[] = $tmp;
            }
            
            return $res;
        }
        public static function apiGetDealership( $GET = [] ) {

            $res = [];

            $rs = CIBlockElement::GetList(
                [],
                [
                    'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
                    'ACTIVE' => 'Y',
                    'PROPERTY_EXTERNAL_CODE' => explode(',', $GET['code']),
                ],
                false,
                false,
                [
                    'ID', 'NAME', 'DETAIL_PAGE_URL', 'PREVIEW_PICTURE', 'PROPERTY_PIC_TABLET_PREVIEW', 'PROPERTY_PIC_MOBILE_PREVIEW',
                    'PROPERTY_EXTERNAL_CODE', 'PROPERTY_CITY', 'PROPERTY_ADDRESS', 'PROPERTY_PHONE', 'PROPERTY_COORDS_LAT', 'PROPERTY_COORDS_LON', 'PROPERTY_BRAND'
                ]
            );
            while ( $ob = $rs->GetNextElement() ) {
                
                $res = $ob->GetFields();
                $prop_s = CIBlockElement::GetProperty(
                    YApp::IBLOCK_DEALERSHIPS,
                    $res['ID'],
                    'sort', 'asc',
                    ['CODE' => 'WORK']
                );
                while( $prop_o = $prop_s->GetNext() ) {
                    $res['WORK'][] = [
                        'VALUE' => $prop_o['VALUE'],
                        'DESCRIPTION' => $prop_o['DESCRIPTION']
                    ];
                }
            }

            $res['LOGO'] = 'https://'.$_SERVER['HTTP_HOST'].CFile::GetPath( CIBlockElement::GetByID($res['PROPERTY_BRAND_VALUE'])->GetNext()['PREVIEW_PICTURE'] );
            $arLinks = [];
            $rs = CIBlockElement::GetProperty(
                YApp::IBLOCK_BRANDS,
                $res['PROPERTY_BRAND_VALUE'],
                [],
                ['CODE'=>'LINK']
            );
            while ( $ob = $rs->GetNext() ) $arLinks[] = ['LINK'=>$ob['VALUE'], 'CITY'=>$ob['DESCRIPTION']];

            $res['SITE'] = $arLinks[0]['LINK'];
            foreach ( $arLinks as $arLink ) if ( $arLink['CITY'] == $res['PROPERTY_CITY_VALUE'] )  $res['SITE'] = $arLink['LINK'];


            $res['DETAIL_PAGE_URL'] = 'https://'.$_SERVER['HTTP_HOST'].$res['DETAIL_PAGE_URL'];
            $res['PIC_DESKTOP_PREVIEW'] = 'https://'.$_SERVER['HTTP_HOST'].CFile::GetPath($res['PREVIEW_PICTURE']);
            $res['PIC_TABLET_PREVIEW'] = 'https://'.$_SERVER['HTTP_HOST'].CFile::GetPath($res['PROPERTY_PIC_TABLET_PREVIEW_VALUE']);
            $res['PIC_MOBILE_PREVIEW'] = 'https://'.$_SERVER['HTTP_HOST'].CFile::GetPath($res['PROPERTY_PIC_MOBILE_PREVIEW_VALUE']);
            foreach( $res as $k => $i ) if ( mb_strripos($k, '~') !== false ) unset($res[$k]);

            return $res;
        }
        public static function apiGetDealerships( $GET = [] ) {

            $res = [];
            $arFilter = [
                'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
                'ACTIVE' => 'Y',
            ];
            $arFilter['PROPERTY_INCOGNITO_VALUE'] = false;
            if ( $GET['mode'] == 'new' ) $arFilter['=PROPERTY_IS_NEW_VALUE'] = 'Да';
            if ( $GET['mode'] == 'used' ) $arFilter['=PROPERTY_IS_NEW_VALUE'] = 'Нет';

            // if ( $GET['city'] )  $arFilter['=PROPERTY_CITY_VALUE'] = $GET['city'];
            // YApp::sp(explode(',', $GET['city']));
            if ( $GET['city'] )  $arFilter['=PROPERTY_CITY_VALUE'] = explode(',', $GET['city']);
            if ( $GET['brand'] ) $arFilter['PROPERTY_BRAND.CODE'] = explode(',', $GET['brand']);

            if ( is_countable(explode(',', $GET['code'])) && count(explode(',', $GET['code'])) ) $arFilter['PROPERTY_EXTERNAL_CODE'] = explode(',', $GET['code']);
            if ( is_countable(explode(',', $GET['code'])) && !count(explode(',', $GET['code'])) ) $arFilter['!PROPERTY_EXTERNAL_CODE'] = false;

            // if filter tags
            if ( $_GET['tag'] ) {

                $rs = CIBlockPropertyEnum::GetList(
                    ['sort'=>'asc'],
                    [
                        'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
                        'CODE' => 'TAG'
                    ]
                );
                while ( $ob = $rs->Fetch() ) if ( in_array($ob['XML_ID'], explode(',',$_GET['tag'])) ) $arFilter['PROPERTY_TAG_VALUE'][] = $ob['VALUE'];
            }



            // YApp::sp( $arFilter );

            $rs = CIBlockElement::GetList(
                ['NAME' => 'ASC'],
                $arFilter,
                false,
                false,
                [
                    'ID', 'NAME', 'PROPERTY_EXTERNAL_CODE', 'PROPERTY_BRAND', 'PROPERTY_CITY', 'PROPERTY_COORDS_LAT', 'PROPERTY_COORDS_LON',
                    'PREVIEW_PICTURE', 'PROPERTY_PIC_TABLET_PREVIEW', 'PROPERTY_PIC_MOBILE_PREVIEW', 'DETAIL_PAGE_URL', 'PROPERTY_ADDRESS'
                ]
            );
            while ( $ob = $rs->GetNextElement() ) {
                
                $tmp = $ob->GetFields();

                // YApp::sp( $tmp );
                
                if ( $tmp['PROPERTY_EXTERNAL_CODE_VALUE'] ) {
                    $t = [
                        'id' => $tmp['ID'],
                        'code' => $tmp['PROPERTY_EXTERNAL_CODE_VALUE'],
                        'name' => $tmp['NAME'],
                        'brand' => CIBlockElement::GetByID($tmp['PROPERTY_BRAND_VALUE'])->GetNext()['CODE'],
                        '_city' => $tmp['PROPERTY_CITY_VALUE'],
                        'coords' => [
                            'lat' => $tmp['PROPERTY_COORDS_LAT_VALUE'],
                            'lon' => $tmp['PROPERTY_COORDS_LON_VALUE']
                        ],
                        'address' => $tmp['PROPERTY_ADDRESS_VALUE']
                    ];
                    switch ($t['_city']) {
                        case 'Краснодар': $t['city'] = 'Краснодаре'; break;
                        case 'Яблоновский': $t['city'] = 'Яблоновском'; break;
                        case 'Новороссийск': $t['city'] = 'Новороссийске'; break;
                        case 'Майкоп': $t['city'] = 'Майкопе'; break;
                        case 'Сочи': $t['city'] = 'Сочи'; break;
                    }
                    if ( $GET['city'] ) {
                        $t['city'] = '';
                        $ccc = explode(',', $GET['city']);
                        foreach ( $ccc as $k => $c ) {
                            switch ($c) {
                                case 'Краснодар': 
                                    $t['city'] .= 'Краснодаре'; 
                                    if ( $k<count($ccc)-1 && $k!=count($ccc)-2 ) {
                                        $t['city'] .= ', ';
                                    } elseif ( $k==count($ccc)-2 ) {
                                        $t['city'] .= ' и ';
                                    }
                                    break;
                                case 'Яблоновский': 
                                    $t['city'] .= 'Яблоновском'; 
                                    if ( $k<count($ccc)-1 && $k!=count($ccc)-2 ) {
                                        $t['city'] .= ', ';
                                    } elseif ( $k==count($ccc)-2 ) {
                                        $t['city'] .= ' и ';
                                    }
                                    break;
                                case 'Новороссийск': 
                                    $t['city'] .= 'Новороссийске'; 
                                    if ( $k<count($ccc)-1 && $k!=count($ccc)-2 ) {
                                        $t['city'] .= ', ';
                                    } elseif ( $k==count($ccc)-2 ) {
                                        $t['city'] .= ' и ';
                                    }
                                    break;
                                case 'Майкоп': 
                                    $t['city'] .= 'Майкопе'; 
                                    if ( $k<count($ccc)-1 && $k!=count($ccc)-2 ) {
                                        $t['city'] .= ', ';
                                    } elseif ( $k==count($ccc)-2 ) {
                                        $t['city'] .= ' и ';
                                    }
                                    break;
                                case 'Сочи': 
                                    $t['city'] .= 'Сочи'; 
                                    if ( $k<count($ccc)-1 && $k!=count($ccc)-2 ) {
                                        $t['city'] .= ', ';
                                    } elseif ( $k==count($ccc)-2 ) {
                                        $t['city'] .= ' и ';
                                    }
                                    break;
                            }
                        }
                        // switch ($GET['city']) {
                        //     case 'Краснодар,Яблоновский': $t['city'] = 'Краснодаре и Яблоновском'; break;
                        //     case 'Краснодар': $t['city'] = 'Краснодаре'; break;
                        //     case 'Яблоновский': $t['city'] = 'Яблоновском'; break;
                        //     case 'Новороссийск': $t['city'] = 'Новороссийске'; break;
                        //     case 'Майкоп': $t['city'] = 'Майкопе'; break;
                        // }
                    }
                    $t['DETAIL_PAGE_URL'] = 'https://'.$_SERVER['HTTP_HOST'].$tmp['DETAIL_PAGE_URL'];
                    $t['PIC_DESKTOP_PREVIEW'] = 'https://'.$_SERVER['HTTP_HOST'].CFile::GetPath($tmp['PREVIEW_PICTURE']);
                    $t['PIC_TABLET_PREVIEW'] = 'https://'.$_SERVER['HTTP_HOST'].CFile::GetPath($tmp['PROPERTY_PIC_TABLET_PREVIEW_VALUE']);
                    $t['PIC_MOBILE_PREVIEW'] = 'https://'.$_SERVER['HTTP_HOST'].CFile::GetPath($tmp['PROPERTY_PIC_MOBILE_PREVIEW_VALUE']);
                    $res[] = $t;
                }
                
            }

            return $res;
        }
        public static function apiGetBrands( $GET= [] ) {

            $res = [];

            $rs = CIBlockElement::GetList(
                [],
                [
                    'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
                    'ACTIVE' => 'Y',
                    'PROPERTY_EXTERNAL_CODE' => explode(',', $GET['dealership']),
                ],
                false,
                false,
                [
                    'ID', 'NAME', 'DETAIL_PAGE_URL', 'DETAIL_PICTURE', 
                    'PROPERTY_EXTERNAL_CODE', 'PROPERTY_CITY', 'PROPERTY_ADDRESS', 'PROPERTY_PHONE', 'PROPERTY_COORDS_LAT', 'PROPERTY_COORDS_LON', 'PROPERTY_BRAND'
                ]
            );
            while ( $ob = $rs->GetNextElement() ) {

                $d = $ob->GetFields();
                $brand = CIBlockElement::GetByID($d['PROPERTY_BRAND_VALUE'])->GetNext();
                $res[] = [
                    'code' => $brand['CODE'],
                    'name' => $brand['NAME']
                ];
            }

            return $res;
        }
        public static function apiGetModels( $GET= [] ) {

            $res = [];

            $rs = CIBlockSection::GetList(
                [],
                [
                    'IBLOCK_ID' => YApp::IBLOCK_PAGES,
                    'ACTIVE' => 'Y',
                    'CODE' => $GET['brand']
                ],
                false,
                ['ID'],
                false
            );
            while ( $ob = $rs->GetNext() ) $section_id = $ob['ID'];

            $rs = CIBlockElement::GetList(
                [],
                [
                    'IBLOCK_ID' => YApp::IBLOCK_PAGES,
                    'IBLOCK_SECTION_ID' => $section_id,
                    'ACTIVE' => 'Y',
                    '=PROPERTY_TEST_DRIVE_VALUE' => 'Да'
                ],
                false,
                false,
                [
                    'ID', 'IBLOCK_ID', 'NAME', 'CODE'
                ]
            );
            while ( $ob = $rs->GetNextElement() ) {

                $m = $ob->GetFields();
                $res[] = [
                    'code' => $m['CODE'],
                    'name' => $m['NAME']
                ];
            }

            return $res;
        }
        public static function apiSendform( $POST ) {

            // Yapp::sp($POST); die;

            $arForm = CForm::GetByID($_POST['FORM_ID'])->Fetch();
            $rs = CFormField::GetList($arForm['ID'], 'N', $by = 's_id',  $order = 'ASC', [], $is_f);
            while ( $ob = $rs->Fetch() ) $arForm['QS'][$ob['SID']] = $ob;
            
            
            $rs = CIBlockElement::GetList(
                [],
                [
                    'IBLOCK_ID' => YApp::IBLOCK_FORM_SETTINGS,
                    'CODE' => $arForm['SID']
                ],
                false, false,
                ['ID']
            );
            while ( $ob = $rs->GetNextElement() ) $arForm['RECIPIENTS_ID'] = $ob->GetFields()['ID'];
            $rs = CIBlockElement::GetProperty(
                YApp::IBLOCK_FORM_SETTINGS,
                $arForm['RECIPIENTS_ID'],
                "sort", "asc",
                ['CODE'=>'RECIPIENTS']
            );
            while ( $ob = $rs->GetNext() )  $arForm['RECIPIENTS'][] = $ob['VALUE'];

            // Yapp::sp($arForm['RECIPIENTS']); die;

            require 'phpmailer/phpmailer/src/Exception.php';
            require 'phpmailer/phpmailer/src/PHPMailer.php';

            $mail = new PHPMailer(true);

            foreach ($arForm['QS'] as $q) {

                switch ( $q['SID'] ) {

                    case 'NAME':
                    case 'PHONE':
                    case 'DATE':
                    case 'EMAIL':
                    case 'BRAND':
                    case 'MODEL':
                        $arIns['form_text_'.$q['ID']] = $_POST[$q['SID']];
                        $mail->Body .= $q['SID'].': '.$_POST[$q['SID']].'<br />';
                        break;
                    
                    case 'DEALERSHIP':
                    case 'DEALERSHIP_NEW':
                    case 'DEALERSHIP_USED':
                    case 'DEALERSHIP_CHUNK':
                        if ( $POST[$q['SID']] ) {
                            $rs = CIBlockElement::GetList(
                                [],
                                [
                                    'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
                                    'ACTIVE' => 'Y',
                                    'CODE' => $_POST[$q['SID']]
                                ],
                                false,
                                false,
                                [
                                    'ID', 'NAME',
                                ]
                            );
                            while ( $ob = $rs->GetNextElement() ) {
                                $arIns['form_text_'.$q['ID']] = $_POST[$q['SID']];
                                $mail->Body .= $q['SID'].': '.$ob->GetFields()['NAME'].'<br />';
                            }
                        }
                        
                        break;
                    
                    default: 
                        $mail->Body .= $q['SID'].': '.$_POST[$q['SID']].'<br />';
                        break;
                }
            }

            $mail->Body .= '<br /><br />Страница источник: <a href="'.$_POST['SOURCE'].'">'.$_POST['SOURCE'].'</a>';

            if ( $arForm['ID'] == 13 ) {
                $mail->Body .= '<br /><br /><br /><br /><br /><br />';
                $mail->Body .= 'SERVER<br />-----------------------<br />';
                $mail->Body .= '<pre>'.print_r($_SERVER, true).'</pre><br /><br />';
                $mail->Body .= 'COOKIE<br />-----------------------<br />';
                $mail->Body .= '<pre>'.print_r($_COOKIE, true).'</pre>';
            }

            if ( $res = CFormResult::Add($arForm['ID'], $arIns, $check_rights = "N") ) {

                // Yapp::sp($res); die;
                
                try {
                
                    //Recipients
                    $mail->setFrom('formsender@yug-avto-expert.ru', (($_POST['SENDER'])?:'Формы сайта yug-avto-expert.ru'));
                    $mail->isHTML(true);
                    $mail->CharSet = 'utf-8';
                    $mail->Subject = 'Заполнена форма '.$_POST['FORM'];
                    if ( $POST['NAME'] == 'testtesttest' ) {
                        $mail->addAddress('anton.boreckiy@yug-avto.ru');
                    } else {
                        foreach ( $arForm['RECIPIENTS'] as $item ) $mail->addAddress($item);
                    }
                    
                    // if ( YApp::getFlagCookie($_COOKIE['YAPPS_ID']) ) {
                    //     $mail->send();
                    // }
                    // Yapp::sp($mail->send()); die;

                    $mail->send();
                    
                    return ['status' => 'success'];

                } catch (Exception $e) {

                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else
            {
                global $strError;
                echo $strError;
            }
            
        }

        private static function httpGet($url) {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 15,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
            ]);
            $resp = curl_exec($ch);
            curl_close($ch);
            return $resp;
        }

        ////////////// RENDER //////////////
        public static function apiMainFilter($POST) {

            $url = 'https://'.YApp::API_DOMAIN.'/API/get/cis/filter/';
            // $url .= ( !empty($POST['brands']) ) ? 'models/' : 'brands/';
            $url .= (($POST['entity']) ?: 'new').'/';
            $url .= '?token=ef6541490c8bb9d481d37020b6a1953e';
            if ( $POST['city'] ) $url .= '&'.http_build_query(explode(',',$POST['city']));
            // if ( $POST['city'] ) $url .= '&city='.$POST['city'];
            if ( !empty($POST['brands']) ) {
                $tmp = [];
                foreach( $POST['brands'] as $item ) $tmp[] = $item['code'];
                sort($tmp);
                $url .= '&brand='.implode(',', $tmp); 
            }
            if ( !empty($POST['models']) ) {
                $tmp = [];
                foreach( $POST['models'] as $item ) $tmp[] = $item['code'];
                sort($tmp);
                $url .= '&model='.implode(',', $tmp);
            }
            if ( !empty($POST['price']) ) {
                $tmp = [];
                foreach( $POST['price'] as $item ) $tmp[] = (int)$item;
                sort($tmp);
                $url .= '&price='.implode(',', $tmp); 
            }
            if ( $POST['param'] ) $url .= '&'.$POST['param']; 
            $url .= '&site='.$_SERVER['HTTP_HOST'];
            // $url .= '&site='.'yug-avto-expert.ru';

            $res = json_decode( self::httpGet($url), true );

            return $res;
        }
        public static function apiRenderMainFilterTags($POST) {

            $res = '';
            if ( !empty($POST['brands']) ) {
                array_multisort(array_column($POST['brands'], 'name'), SORT_ASC, SORT_STRING, $POST['brands']);
                foreach ( $POST['brands'] as $k => $item ) {
                    $res .= '<a href="#" class="d-inline-flex list-inline-item bg-yalightgray b-radius-yaradius8 py-1 px-2 my-2 c-yadarkgray c-h-yadarkgray text-decoration-none" role="tag" data-list="brands" data-indx="'.$item['indx'].'">'.$item['name'].' <img class="ms-2" src="https://yug-avto.ru/local/templates/yugavto.theme.2023/assets/images/svg/cross.svg" /></a>';
                }
            }
            if ( !empty($POST['models']) ) {
                array_multisort(array_column($POST['models'], 'name'), SORT_ASC, SORT_STRING, $POST['models']);
                foreach ( $POST['models'] as $item ) {
                    $res .= '<a href="#" class="d-inline-flex list-inline-item bg-yalightgray b-radius-yaradius8 py-1 px-2 my-2 c-yadarkgray c-h-yadarkgray text-decoration-none" role="tag" data-list="models" data-indx="'.$item['indx'].'">'.$item['name'].' <img class="ms-2" src="https://yug-avto.ru/local/templates/yugavto.theme.2023/assets/images/svg/cross.svg" /></a>';
                }
            }
            if ( !empty($POST['price']) ) {
                sort($POST['price']);
                $res .= '<a href="#" class="d-inline-flex list-inline-item bg-yalightgray b-radius-yaradius8 py-1 px-2 my-2 c-yadarkgray c-h-yadarkgray text-decoration-none" role="tag" data-list="price">'.number_format((int)$POST['price'][0], 0, '.', ' ').' ₽ - '.number_format((int)$POST['price'][1], 0, '.', ' ').' ₽ <img class="ms-2" src="https://yug-avto.ru/local/templates/yugavto.theme.2023/assets/images/svg/cross.svg" /></a>';
            }
            if ( $res != '' ) $res .= '<a href="#" class="d-inline-flex list-inline-item bg-yawhite b-radius-yaradius8 py-1 px-2 my-2 c-yablack c-h-yablack text-decoration-none block-title" role="clear">Сбросить <img class="ms-2" src="https://yug-avto.ru/local/templates/yugavto.theme.2023/assets/images/svg/cross.svg" /></a>';

            return $res;
        }
        public static function apiRenderMainFilterSelect( $POST ) {
            
            $res = '';
            foreach ( $POST['items'] as $k => $item ) {
                $res .= '<a href="#" class="filter-droplist-item py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray" data-list="'.$POST['list'].'" data-value="'.$item['code'].'" data-indx="'.$item['indx'].'">'.$item['name'].'</a>'; 
            }

            return $res;
        }
        public static function apiRenderMainFilterLink( $POST ) {

            
            $link = '/cars/';
            $link .= ( $POST['entity'] ) ?: 'new'; $link .= '/';
            if ( $POST['city'] && count(explode(',',$POST['city'])) == 1 ) $link .= YApp::getCityAlias($POST['city']).'/';
            if ( is_countable($POST['brands']) && count($POST['brands']) == 1 ) $link .= $POST['brands'][0]['code'].'/';
            if ( (is_countable($POST['brands']) && count($POST['brands']) == 1) && (is_countable($POST['models']) && count($POST['models']) == 1) ) $link .= $POST['models'][0]['code'].'/';

            if ( (is_countable($POST['brands']) && count($POST['brands'])>1) || (is_countable($POST['models']) && count($POST['models'])>1) || !empty($POST['price']) ) $link .= '?';
            
            if ( is_countable($POST['brands']) && count($POST['brands'])>1 ) {
                $link .= 'brand=';
                $tmp = [];
                foreach ( $POST['brands'] as $item ) $tmp[] = $item['code'];
                $link .= implode(',', $tmp); 
            }
            if ( (is_countable($POST['models']) && count($POST['models'])>1) || (is_countable($POST['brands']) && count($POST['brands'])>1) ) {
                $link .= '&model=';
                $tmp = [];
                foreach ( $POST['models'] as $item ) $tmp[] = $item['code'];
                $link .= implode(',', $tmp); 
            }
            if (!empty($POST['price'])) $link .= '&price='.implode(',', $POST['price']);
            if ( $POST['param'] ) $link .= '?&'.$POST['param']; 
            $link = str_ireplace(['?&'], '?', $link);

            $res = '<a href="'.$link.'" class="d-block text-center c-yalightblack c-h-yalightblack bg-h-yayellow bg-yadarkyellow text-decoration-none b-radius-yaradius-15 but-lg fw-bold">';
            $res .= 'Показать <span>'.number_format((int)$POST['count'], 0, '.', ' ').'</span> авто';
            $res .= '</a>';
           
            return $res;
        }
        public static function apiRenderMainFilterBrands( $POST ) {
            $brands = $POST['brands'];
            array_multisort(array_column($brands, 'vehicles'), SORT_DESC, SORT_NUMERIC, $brands);
            ?>
            <div class="row mt-5 mb-3 cis-filter-on-main-brands">
                <div class="col-md-9">
                    <h1 class="h3 fw-normal">Автомобили в наличии <a href="/dealerships/" role="top-menu-show-list-city">в <?= $POST['in_city'];?></a></h1>
                </div>
                <div class="col-md-3 text-start text-md-end">
                    <a href="/cars/used/" 
                        class="c-yablack c-h-yablack text-decoration-none text-minus">
                        Все марки
                        <svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg>
                    </a>
                </div>
            </div>
            <div class="row mb-5">
                <?php if ( !empty($brands) ) { ?>
                    <?php foreach ( array_chunk($brands, 18)[0] as $k => $item ) { ?>
                    <div class="col-6 col-md-3 col-lg-2 cis-filter-on-main-brands-item">
                        <a 
                            href="/cars/used/<?= $item['code'];?>/" 
                            class="text-decoration-none c-yadarkgray c-h-yadarkgray d-block b-radius-small py-1 px-2 d-flex align-items-center justify-content-between"
                            >
                            <?= $item['name'];?>
                            <span class="b-radius-yaradius-3 bg-yalightgray c-yalightblack bg-h-yalightgray text-center fw-bold"><?= $item['vehicles'];?></span>
                        </a>
                    </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="col text-center"><h4 class="block-title">К сожалению таких автомобилей не найдено</h4></div>
                <?php } ?>
            </div>
            <?php
        }

        public static function transformImageUrl($url) {
            $parts = parse_url($url);
            if (!isset($parts['path'])) return $url;
            $path = $parts['path'];
            if (preg_match('#^/upload/Cis/vehicles/\d+/([^/]+)$#', $path, $m)
                && !str_contains($path, '/sm/')) {
                $path = dirname($path) . '/sm/' . $m[1];
            }
            if (preg_match('#^/upload/Cis/#', $path)) {
                $host = YApp::API_DOMAIN;
                $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
                $url = $scheme . '://' . $host . $path;
                if (isset($parts['query'])) $url .= '?' . $parts['query'];
            }
            return $url;
        }

        public static function apiRenderMainCompilations($POST) {

            $type = ($POST['entity'] == 'used') ? '2' : '1';
            $url = 'https://'.YApp::GO_API_DOMAIN.'/api/v1/cis/random?token=ef6541490c8bb9d481d37020b6a1953e&type='.$type.'&limit=12';
            if ( $POST['query'] ) $url .= '&'.$POST['query'];
            if ( $POST['price'] ) $url .= '&price='.$POST['price'];
            if ( $POST['city'] ) $url .= '&city='.implode(',',$POST['city']);
            
            $res = json_decode( self::httpGet($url), true);
            if (is_array($res['items'] ?? null)) {
                foreach ($res['items'] as &$item) {
                    if (!empty($item['image'])) {
                        $item['image'] = self::transformImageUrl($item['image']);
                    }
                    if (!empty($item['images'])) {
                        foreach ($item['images'] as &$img) {
                            if (!empty($img['preview'])) {
                                $img['preview'] = self::transformImageUrl($img['preview']);
                            }
                            if (!empty($img['preview_large'])) {
                                $img['preview_large'] = self::transformImageUrl($img['preview_large']);
                            }
                        }
                        unset($img);
                    }
                }
                unset($item);
            }
            ?>
            <?php if ( $res['totalCount'] ) { ?>
            <div 
                class="d-none compilations-on-main-data" 
                data-text="Показать <?= number_format((int)$res['totalCount'], 0, '.', ' ');?> <?= YApp::getWorld($res['totalCount'], 'a');?>"
                data-range='<?= json_encode($res['ranges']['price']);?>'
                data-query="<?= $POST['query'];?>"
                data-link="<?= $POST['link'];?>"
                ></div>
            <?php foreach ( $res['items'] as $item ) { ?>
			<div class="swiper-slide">
				<?php
				$vehicleMode = $POST['entity'] ?: 'new';
				$templatePath = '/local/templates/yugavto.expert.theme';
				include $_SERVER['DOCUMENT_ROOT'].$templatePath.'/include/item_vehicle.php';
				?>
			</div>
			<?php } ?>
            <?php } else { ?>
            <div 
                class="d-none compilations-on-main-data" 
                data-text="Показать все автомобили"
                data-range='<?= json_encode($res['ranges']['price']);?>'
                data-query="<?= $POST['query'];?>"
                data-link="/cars/<?= (($POST['entity'])?:'new');?>/"
                ></div>
            <p class="my-5 text-center w-100">К сожалению таких автомобилей не найдено</p>
            <?php } ?>
            <?php 
            return '';
        }
        public static function apiMainCardsLinks($POST) {
            
            $res = [
                'pass' => '/cars/used/'.((count($POST['city'])==1)?YApp::getCityAlias($POST['city'][0]).'/':'').'?!dealership=1489',
                'comm' => '/cars/used/'.((count($POST['city'])==1)?YApp::getCityAlias($POST['city'][0]).'/':'').'?dealership=1489'
            ];
            return $res;
        }





        ////////////// CABINET //////////////
        public static function Auth() {
            
        }
    }