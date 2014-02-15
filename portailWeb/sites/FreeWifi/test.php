<? 

require("ua-parser-master/php/uaparser.php"); 

$ua = $_SERVER['HTTP_USER_AGENT'];

$parser = new UAParser;
$result = $parser->parse($ua);

print "ua family: " . $result->ua->family; ?><br /><?                // Safari
print "major: " . $result->ua->major;            ?><br /><?     // 6
print "minor: " . $result->ua->minor;         ?><br /><?        // 0
print "patch: " . $result->ua->patch;             ?><br /><?    // 2
print "toString: " . $result->ua->toString;           ?><br /><?   // Safari 6.0.2
print "toVersionString: " . $result->ua->toVersionString;     ?><br /><?  // 6.0.2

print "os family: " . $result->os->family;     ?><br /><?           // Mac OS X
print "major: " . $result->os->major;      ?><br /><?           // 10
print "minor: " . $result->os->minor;      ?><br /><?           // 7
print "patch: " . $result->os->patch;       ?><br /><?          // 5
print "minor: " . $result->os->patch_minor;     ?><br /><?      // [null]
print "toString: " . $result->os->toString;      ?><br /><?        // Mac OS X 10.7.5
print "toVersionString: " . $result->os->toVersionString;    ?><br /><?   // 10.7.5

print "family (other): " . $result->device->family;   ?><br /><?         // Other

print "toFullString: " . $result->toFullString;   ?><br /><?           // Safari 6.0.2/Mac OS X 10.7.5
print "original: " . $result->uaOriginal;    ?><br /><?            // Mozilla/5.0 (Macintosh; Intel Ma...


?>
