<?php
# Protect against web entry
if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

// https://www.mediawiki.org/wiki/Manual:Short_URL
$wgScriptPath = "/w";

// The URL path to static resources (images, scripts, etc.)
$wgResourceBasePath = $wgScriptPath;

$wgLogos = [
	'icon' => "$wgScriptPath/icon.png",
	'1x' => "$wgScriptPath/logo-1x.png",
	'1.5x' => "$wgScriptPath/logo-1.5x.png",
	'2x' => "$wgScriptPath/logo-2x.png",
	'svg' => "$wgScriptPath/logo.svg",
];
// $wgFavicon = "$wgScriptPath/favicon.ico";
$wgFavicon = "$wgScriptPath/favicon.png";

// UPO means: this is also a user preference option

$wgEnableEmail = true;
$wgEnableUserEmail = true; # UPO

$wgEmergencyContact = "";
$wgPasswordSender = "";

$wgEnotifUserTalk = false; # UPO
$wgEnotifWatchlist = false; # UPO
$wgEmailAuthentication = true;

## Database settings
$wgDBtype = "mysql";
$wgDBserver = "db";
$wgDBname = "mediawiki";
$wgDBuser = "mwuser";
$wgDBpassword = "";

# MySQL specific settings
$wgDBprefix = "";
$wgDBssl = false;

# MySQL table options to use during installation or update
$wgDBTableOptions = "ENGINE=InnoDB, DEFAULT CHARSET=binary";

# Shared database table
# This has no effect unless $wgSharedDB is also set.
$wgSharedTables[] = "actor";

## Shared memory settings
$wgMainCacheType = CACHE_ACCEL;
$wgMemCachedServers = [];

## To enable image uploads, make sure the 'images' directory
## is writable, then set this to true:
$wgEnableUploads = false;
$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "/usr/bin/convert";

# InstantCommons allows wiki to use images from https://commons.wikimedia.org
$wgUseInstantCommons = false;

# Periodically send a pingback to https://www.mediawiki.org/ with basic data
# about this MediaWiki instance. The Wikimedia Foundation shares this data
# with MediaWiki developers to help guide future development efforts.
$wgPingback = true;

# Site language code, should be one of the list in ./includes/languages/data/Names.php
$wgLanguageCode = "en";

# Time zone
$wgLocaltimezone = "UTC";

## Set $wgCacheDirectory to a writable directory on the web server
## to make your wiki go slightly faster. The directory should not
## be publicly accessible from the web.
#$wgCacheDirectory = "$IP/cache";

$wgSecretKey = getenv('MW_SECRETKEY');
$wgUpgradeKey = getenv('MW_UPGRADEKEY');

# Changing this will log out all existing sessions.
$wgAuthenticationTokenVersion = "1";

## For attaching licensing metadata to pages, and displaying an
## appropriate copyright notice / icon. GNU Free Documentation
## License and Creative Commons licenses are supported so far.
$wgRightsPage = ""; # Set to the title of a wiki page that describes your license/copyright
$wgRightsUrl = "";
$wgRightsText = "";
$wgRightsIcon = "";

$wgDiff3 = "/usr/bin/diff3";

if ( getenv( 'MW_SHOW_EXCEPTION_DETAILS' ) === 'true' ) {
    $wgShowExceptionDetails = true;
}

########################### Core Settings ##########################
$wgLanguageCode = 'en';
$wgSitename = 'euc.repair';
$wgMetaNamespace = "euc.repair";
$wgServer = getenv('MW_SITE_SERVER');
$wgEnableUploads = true;
$wgUseInstantCommons = false;

# Enable use of raw HTML within <html>
# TODO: When going into production, KILL THIS WITH HAMMERS
$wgRawHtml = true;

## https://www.mediawiki.org/wiki/Manual:Short_URL
$wgArticlePath = '/wiki/$1';
## Also see mediawiki.conf

##### Improve performance
# https://www.mediawiki.org/wiki/Manual:$wgMainCacheType
# Use Memcached, see https://www.mediawiki.org/wiki/Memcached
$wgMainCacheType = CACHE_MEMCACHED;
$wgParserCacheType = CACHE_MEMCACHED; # optional
$wgMessageCacheType = CACHE_MEMCACHED; # optional
$wgMemCachedServers = explode( ',', getenv( 'MW_MEMCACHED_SERVERS' ) );
$wgSessionsInObjectCache = true; # optional
$wgSessionCacheType = CACHE_MEMCACHED; # optional

# Use Varnish accelerator
$tmpProxy = getenv( 'MW_PROXY_SERVERS' );
if ( $tmpProxy ) {
    # https://www.mediawiki.org/wiki/Manual:Varnish_caching
    $wgUseSquid = true;
    $wgSquidServers = explode( ',', $tmpProxy );
    $wgUsePrivateIPs = true;
    $wgHooks['IsTrustedProxy'][] = function( $ip, &$trusted ) {
        // Proxy can be set as a name of proxy container
        if ( !$trusted ) {
            global $wgSquidServers;
            foreach ( $wgSquidServers as $proxy ) {
                if ( !ip2long( $proxy ) ) { // It is name of proxy
                    if ( gethostbyname( $proxy ) === $ip ) {
                        $trusted = true;
                        return;
                    }
                }
            }
        }
    };
}
//Use $wgSquidServersNoPurge if you don't want MediaWiki to purge modified pages
//$wgSquidServersNoPurge = array('127.0.0.1');

####################### Email #########################
$wgEnableEmail = true;

####################### Uploads #########################
# Set this value if needed
# $wgUploadSizeWarning
$wgMaxUploadSize = 209715200; # 200 mebibytes

####################### Extensions #########################
wfLoadExtension('AbuseFilter');
wfLoadExtension('Babel');
wfLoadExtension('CategoryTree');
wfLoadExtension('CheckUser');
wfLoadExtension('Cite');
wfLoadExtension('CiteThisPage');
wfLoadExtension('cldr');
wfLoadExtension('CleanChanges');
wfLoadExtension('CodeEditor'); 
wfLoadExtension('ConfirmEdit');
wfLoadExtension('CSS');
wfLoadExtension('DiscussionTools');
wfLoadExtension('DisplayTitle');
# FIXME: Reenable
# wfLoadExtension( 'Drafts' );
wfLoadExtension('Echo');
wfLoadExtension('ElectronPdfService');
# wfLoadExtension('Gadgets');
wfLoadExtension('ImageMap');
wfLoadExtension('InputBox');
wfLoadExtension('Interwiki');
wfLoadExtension('Linter');
wfLoadExtension('LoginNotify');
wfLoadExtension('Math');
wfLoadExtension('MultimediaViewer');
wfLoadExtension('Nuke');
wfLoadExtension('OATHAuth');
wfLoadExtension('PageImages');
wfLoadExtension('ParserFunctions');
wfLoadExtension('PdfHandler');
wfLoadExtension('Poem');
wfLoadExtension('Popups');
wfLoadExtension('RelatedArticles');
wfLoadExtension('ReplaceText');
wfLoadExtension('RSS');
wfLoadExtension('SecureLinkFixer');
wfLoadExtension('Scribunto');
wfLoadExtension('ShortDescription');
wfLoadExtension('Shubara');
wfLoadExtension('SpamBlacklist');
wfLoadExtension('SyntaxHighlight_GeSHi');
# wfLoadExtension( 'TemplateStyles' );
wfLoadExtension('TextExtracts');
wfLoadExtension('Thanks');
wfLoadExtension('TitleBlacklist');
wfLoadExtension('UniversalLanguageSelector');
wfLoadExtension('VisualEditor');
wfLoadExtension('WikiEditor');

### Math ###
$wgMathInternalRestbaseURL = getenv('MW_REST_RESTBASE_URL');

### DisplayTitle ###
$wgAllowDisplayTitle = true;
$wgRestrictDisplayTitle = false;
### SpamBlacklist ###
$wgSpamBlacklistFiles = array(
   "https://meta.wikimedia.org/w/index.php?title=Spam_blacklist&action=raw&sb_ver=1",
   "https://en.wikipedia.org/w/index.php?title=MediaWiki:Spam-blacklist&action=raw&sb_ver=1"
);
### TitleBlacklist ###
$wgTitleBlacklistSources = array(
    array(
         'type' => 'localpage',
         'src'  => 'MediaWiki:Titleblacklist',
    ),
    array(
         'type' => 'url',
         'src'  => 'https://meta.wikimedia.org/w/index.php?title=Title_blacklist&action=raw',
    ),
);

### SyntaxHighlight_GeSHi ###
$wgPygmentizePath = '/usr/bin/pygmentize';

### CheckUser ###
$wgGroupPermissions['sysop']['checkuser'] = true;
$wgGroupPermissions['sysop']['checkuser-log'] = true;

### CleanChanges
#$wgDefaultUserOptions['usenewrc'] = 1;

### WikiEditor ###
# Enables use of WikiEditor by default but still allows users to disable it in preferences
$wgDefaultUserOptions['usebetatoolbar'] = 1;
# Enables link and table wizards by default but still allows users to disable them in preferences
$wgDefaultUserOptions['usebetatoolbar-cgd'] = 1;
# Displays the Preview and Changes tabs
$wgDefaultUserOptions['wikieditor-preview'] = 1;
# Displays the Publish and Cancel buttons on the top right side
$wgDefaultUserOptions['wikieditor-publish'] = 1;

### VisualEditor ###
$tmpRestDomain = getenv( 'MW_REST_DOMAIN' );
$tmpRestParsoidUrl = getenv( 'MW_REST_PARSOID_URL' );

// Enable by default for everybody
$wgDefaultUserOptions['visualeditor-enable'] = 1;

// TODO: check this out
// Optional: Set VisualEditor as the default for anonymous users
// otherwise they will have to switch to VE
// $wgDefaultUserOptions['visualeditor-editor'] = "visualeditor";

// Don't allow users to disable it
$wgHiddenPrefs[] = 'visualeditor-enable';

// OPTIONAL: Enable VisualEditor's experimental code features
#$wgDefaultUserOptions['visualeditor-enable-experimental'] = 1;

$wgVirtualRestConfig['modules']['parsoid'] = [
        // URL to the Parsoid instance
        'url' => $tmpRestParsoidUrl,
        // Parsoid "domain", see below (optional)
        'domain' => $tmpRestDomain,
        // Parsoid "prefix", see below (optional)
        'prefix' => $tmpRestDomain,
];

$tmpRestRestbaseUrl = getenv( 'MW_REST_RESTBASE_URL' );
if ( $tmpRestRestbaseUrl ) {
    $wgVirtualRestConfig['modules']['restbase'] = [
    'url' => $tmpRestRestbaseUrl,
    'domain' => $tmpRestDomain,
    'parsoidCompat' => false
    ];

    $tmpRestProxyPath = getenv( 'MW_REST_RESTBASE_PROXY_PATH' );
    if ( $tmpProxy && $tmpRestProxyPath ) {
        $wgVisualEditorFullRestbaseURL = $wgServer . $tmpRestProxyPath;
    } else {
        $wgVisualEditorFullRestbaseURL = $wgServer . ':' . getenv( 'MW_REST_RESTBASE_PORT' ) . "/$tmpRestDomain/";
    }
    $wgVisualEditorRestbaseURL = $wgVisualEditorFullRestbaseURL . 'v1/page/html/';
}

########################### Search Type ############################
// TODO: bro i HAVE to make elasticsearch work here, stock MW search is straight ass
switch( getenv( 'MW_SEARCH_TYPE' ) ) {
    case 'CirrusSearch':
        # https://www.mediawiki.org/wiki/Extension:CirrusSearch
        wfLoadExtension( 'Elastica' );
	wfLoadExtension( 'CirrusSearch' );
	$wgDisableSearchUpdate = true;
        $wgCirrusSearchServers =  explode( ',', getenv( 'MW_CIRRUS_SEARCH_SERVERS' ) );
        if ( $flowNamespaces ) {
            $wgFlowSearchServers = $wgCirrusSearchServers;
        }
        $wgSearchType = 'CirrusSearch';
        break;
    default:
        $wgSearchType = null;
}

### RelatedArticles ###
$wgRelatedArticlesFooterAllowedSkins = ['vector-2022', 'vector', 'citizen'];
$wgRelatedArticlesUseCirrusSearch = true;
$wgRelatedArticlesDescriptionSource = 'pagedescription';

### Scribunto ###
$wgScribuntoDefaultEngine = 'luastandalone';

######################### Skins ######################### 

$wgDefaultSkin = 'citizen';
wfLoadSkin('Vector');
wfLoadSkin('MinervaNeue');
wfLoadSkin('Timeless');
wfLoadSkin('MonoBook');
wfLoadSkin('CologneBlue');
wfLoadSkin('Citizen');

######################### Permissions ######################### 

# Disable anonymous editing
$wgGroupPermissions['*']['edit'] = false;

# Prevent new user registrations except by sysops
$wgGroupPermissions['*']['createaccount'] = false;

$wgNamespacesWithSubpages[NS_MAIN] = true;