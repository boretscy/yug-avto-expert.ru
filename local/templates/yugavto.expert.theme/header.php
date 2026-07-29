<?php
    // $_SERVER['HTTP_HOST'] = 'yug-avto-expert.ru';
    if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); CModule::IncludeModule('iblock'); ?>
<?php 
    use Bitrix\Main\Page\Asset;
    $Asset = Asset::getInstance();
    YApp::setFlagCookie();
?>
<!doctype html>
<html lang="ru">
    <head>
        <!-- Head.Start include area -->
        <?php $APPLICATION->IncludeFile( SITE_TEMPLATE_PATH.'/include/_head.start.php', [], []); ?>
        <!-- // Head.Start include area -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bitrix Head -->
        <?php $APPLICATION->ShowHead();?>
        <?php /* if ( CSite::InDir('/cars/used/') ) { ?>
        <link rel="canonical" href="<?=$APPLICATION->GetProperty("canonical")?>"/>
        <?php } */ ?>
        <!-- // Bitrix Head -->

        <title><?php $APPLICATION->ShowTitle();?></title>

        <link rel="dns-prefetch" href="//apps.yug-avto.ru">
        <link rel="preconnect" href="https://apps.yug-avto.ru" crossorigin>

        <?php 
            $Asset->addCss(SITE_TEMPLATE_PATH.'/assets/css/lib/bootstrap.min.css');
            $Asset->addCss(SITE_TEMPLATE_PATH.'/assets/css/lib/swiper-bundle.min.css');
            $Asset->addCss(SITE_TEMPLATE_PATH.'/assets/css/lib/remodal.min.css');
            $Asset->addCss(SITE_TEMPLATE_PATH.'/assets/css/lib/remodal-default-theme.min.css');
            $Asset->addCss(SITE_TEMPLATE_PATH.'/assets/css/lib/hint.min.css');
            $Asset->addCss(SITE_TEMPLATE_PATH.'/assets/fonts/font.css?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/fonts/font.css'));
            
            if (defined('ENABLE_FRONTEND_OPTIMIZATION') && ENABLE_FRONTEND_OPTIMIZATION && file_exists($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/css/bundle.app.min.css')) {
                $Asset->addCss(SITE_TEMPLATE_PATH.'/assets/css/bundle.app.min.css?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/css/bundle.app.min.css'));
            } else {
                $Asset->addCss(SITE_TEMPLATE_PATH.'/assets/css/app.css?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/css/app.css'));
                $Asset->addCss(SITE_TEMPLATE_PATH.'/assets/css/style.css?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/css/style.css'));
            }

            $Asset->addJs(SITE_TEMPLATE_PATH.'/assets/js/lib/jquery.min.js');
            $Asset->addJs(SITE_TEMPLATE_PATH.'/assets/js/lib/remodal.min.js');
            $Asset->addJs(SITE_TEMPLATE_PATH.'/assets/js/lib/swiper-bundle.min.js');
            $Asset->addJs(SITE_TEMPLATE_PATH.'/assets/js/lib/mask.min.js');
            
            if (defined('ENABLE_FRONTEND_OPTIMIZATION') && ENABLE_FRONTEND_OPTIMIZATION && file_exists($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/js/bundle.app.min.js')) {
                $Asset->addJs(SITE_TEMPLATE_PATH.'/assets/js/bundle.app.min.js?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/js/bundle.app.min.js'));
            } else {
                $Asset->addJs(SITE_TEMPLATE_PATH.'/assets/js/app.js?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/js/app.js'));
            }
        ?>

        <!-- Favicon -->
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="apple-touch-icon" sizes="57x57" href="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/apple-icon-57x57.png?2">
        <link rel="apple-touch-icon" sizes="60x60" href="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/apple-icon-60x60.png?2">
        <link rel="apple-touch-icon" sizes="72x72" href="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/apple-icon-72x72.png?2">
        <link rel="apple-touch-icon" sizes="76x76" href="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/apple-icon-76x76.png?2">
        <link rel="apple-touch-icon" sizes="114x114" href="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/apple-icon-114x114.png?2">
        <link rel="apple-touch-icon" sizes="120x120" href="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/apple-icon-120x120.png?2">
        <link rel="apple-touch-icon" sizes="144x144" href="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/apple-icon-144x144.png?2">
        <link rel="apple-touch-icon" sizes="152x152" href="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/apple-icon-152x152.png?2">
        <link rel="apple-touch-icon" sizes="180x180" href="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/apple-icon-180x180.png?2">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/android-icon-192x192.png?2">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/favicon-32x32.png?2">
        <link rel="icon" type="image/png" sizes="96x96" href="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/favicon-96x96.png?2">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/favicon-16x16.png?2">
        <link rel="manifest" href="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/manifest.json?2">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/ms-icon-144x144.png?2">
        <meta name="theme-color" content="#ffffff">
        <!-- // Favicon -->

        <!-- Head.End include area -->
        <?php $APPLICATION->IncludeFile( SITE_TEMPLATE_PATH.'/include/_head.end.php', [], []); ?>
        <!-- // Head.End include area -->
        
        <script data-skip-moving="true">
            <?php /* var DEALERSHIPS = <?= file_get_contents('https://yug-avto.ru/api/dealerships?mode=all')//file_get_contents($_SERVER['DOCUMENT_ROOT'].'/api/data/dealerships.json');?>;
            var BRANDS = [], MODELS =[];
            var SELECTED_DEALERSHIP = null, SELECTED_BRAND = null, SELECTED_MODEL = null; */ ?>
            let CONNECTOR = {};
        </script>

        <script data-skip-moving="true">
            window.REMODAL_GLOBALS = {
                DEFAULTS: {
                    hashTracking: false
                }
            };
        </script>

        <meta property="og:title" content="<?= $APPLICATION->ShowProperty('title');?>"/>
        <meta property="og:description" content="<?= $APPLICATION->ShowProperty('description');?>"/>
        <meta property="og:site_name" content="Юг-Авто Эксперт - автомобили с пробегом и гарантией"/>
        <meta property="og:type" content="website"/>
        <meta property="og:url" content="<?= $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>"/>
        <meta property="og:image" content="<?= $APPLICATION->ShowProperty('image', $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].SITE_TEMPLATE_PATH.'/assets/images/logo-25.jpg');?>">

        <?php if ($APPLICATION->GetCurPage(false) === '/') { ?>
        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "WebSite",
          "name": "Юг-Авто Эксперт",
          "url": "https://yug-avto-expert.ru/",
          "potentialAction": {
            "@type": "SearchAction",
            "target": "https://yug-avto-expert.ru/cars/used/?brand={search_term_string}",
            "query-input": "required name=search_term_string"
          }
        }
        </script>
        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "AutoDealer",
          "name": "Юг-Авто Эксперт",
          "image": "https://yug-avto-expert.ru/local/templates/yugavto.expert.theme/assets/images/logo.svg",
          "@id": "https://yug-avto-expert.ru/#autodealer",
          "url": "https://yug-avto-expert.ru/",
          "telephone": "+78612600000",
          "priceRange": "$$",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "ул. Новороссийская, 210",
            "addressLocality": "Краснодар",
            "postalCode": "350059",
            "addressCountry": "RU"
          },
          "openingHoursSpecification": {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": [
              "Monday",
              "Tuesday",
              "Wednesday",
              "Thursday",
              "Friday",
              "Saturday",
              "Sunday"
            ],
            "opens": "08:00",
            "closes": "20:00"
          },
          "sameAs": [
            "https://vk.com/yugavtoexpert",
            "https://t.me/yugavtoexpert"
          ]
        }
        </script>
        <?php } else { ?>
        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "WebPage",
          "name": "<?= htmlspecialchars($APPLICATION->GetTitle());?>",
          "description": "<?= htmlspecialchars($APPLICATION->GetProperty('description'));?>",
          "url": "<?= $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>"
        }
        </script>
        <?php } ?>

    </head>

    <body>
        <?php
            // Вывод телефона из highloadblock
            CModule::IncludeModule("highloadblock");
            use Bitrix\Highloadblock as HL;
            use Bitrix\Main\Entity;

            $hlbl = 1;
            $hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch();
            $entity = HL\HighloadBlockTable::compileEntity($hlblock);
            $entity_data_class = $entity->getDataClass();

            $res = $entity_data_class::getList(array(
                'select' => array('*')
            ));
            foreach ($res->fetchAll() as $itemHl){

                if(is_countable($itemHl['UF_VALUE']) && count($itemHl['UF_VALUE']) == 1){
                    $item['VALUE'] = $itemHl['UF_VALUE'][0];
                }

                $result[$item['UF_CODE']] = $itemHl;
            }
        ?>

        <?php if ( strripos($APPLICATION->GetCurPage(false), '/cabinet')===false ) $APPLICATION->ShowPanel();?>
        <!-- Body.Start include area -->
        <?php $APPLICATION->IncludeFile( SITE_TEMPLATE_PATH.'/include/_body.start.php', [], []); ?>
        <!-- // Body.Start include area -->

        <!-- Top.Row include area -->
        <?php if ( strripos($APPLICATION->GetCurPage(false), '/cabinet')!==false ) {
            $APPLICATION->IncludeComponent(
                "bitrix:menu", 
                'top.cabinet', 
                array(
                    "ALLOW_MULTI_SELECT" => "N",
                    "CHILD_MENU_TYPE" => "cabinet",
                    "DELAY" => "N",
                    "MAX_LEVEL" => "1",
                    "MENU_CACHE_GET_VARS" => array(
                    ),
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_TYPE" => "A",
                    "MENU_CACHE_USE_GROUPS" => "N",
                    "ROOT_MENU_TYPE" =>  ($USER->IsAuthorized() ) ? "top_menu_cabinet" : 'top_menu',
                    "USE_EXT" => "N",
                    "COMPONENT_TEMPLATE" => "top.cabinet",
                    "COMPOSITE_FRAME_MODE" => "A",
                    "COMPOSITE_FRAME_TYPE" => "AUTO"
                ),
                false
            );
        } elseif ( strripos($APPLICATION->GetCurPage(false), '/test')!==false ) {
            $APPLICATION->IncludeComponent(
                "bitrix:menu", 
                'top', 
                array(
                    "ALLOW_MULTI_SELECT" => "N",
                    "CHILD_MENU_TYPE" => "left",
                    "DELAY" => "N",
                    "MAX_LEVEL" => "1",
                    "MENU_CACHE_GET_VARS" => array(
                    ),
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_TYPE" => "A",
                    "MENU_CACHE_USE_GROUPS" => "N",
                    "ROOT_MENU_TYPE" => "top_menu",
                    "USE_EXT" => "N",
                    "COMPONENT_TEMPLATE" => "top",
                    "COMPOSITE_FRAME_MODE" => "A",
                    "COMPOSITE_FRAME_TYPE" => "AUTO"
                ),
                false
            );
        } else {
            $APPLICATION->IncludeComponent(
                "bitrix:menu", 
                "top", 
                array(
                    "ALLOW_MULTI_SELECT" => "N",
                    "CHILD_MENU_TYPE" => "left",
                    "DELAY" => "N",
                    "MAX_LEVEL" => "1",
                    "MENU_CACHE_GET_VARS" => array(
                    ),
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_TYPE" => "A",
                    "MENU_CACHE_USE_GROUPS" => "N",
                    "ROOT_MENU_TYPE" => "top_menu",
                    "USE_EXT" => "N",
                    "COMPONENT_TEMPLATE" => "top",
                    "COMPOSITE_FRAME_MODE" => "A",
                    "COMPOSITE_FRAME_TYPE" => "AUTO"
                ),
                false
            );
        } ?>
        <!-- // Top.Row include area -->

        <?php if ( $APPLICATION->GetCurPage(false) !== '/' ) {
            
            $APPLICATION->IncludeComponent(
                'bitrix:breadcrumb', 
                'breadcrumbs', 
                [
                    "PATH" => "",	// Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
                    "SITE_ID" => "s1",	// Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
                    "START_FROM" => "0",	// Номер пункта, начиная с которого будет построена навигационная цепочка
                ],
                false
            );
        } ?>