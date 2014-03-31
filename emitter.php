<?
# We start with the standard headers. PHP allows us this much
header("Cache-Control: no-cache");
header("Cache-Control: private");
header("Pragma: no-cache");
header("Content-Type: application/json");

# Set this so PHP doesn't timeout during a long stream
set_time_limit(0);

# Disable Apache and PHP's compression of output to the client
@apache_setenv('no-gzip', 1);
@ini_set('zlib.output_compression', 0);

# Set implicit flush, and flush all current buffers
@ini_set('implicit_flush', 1);
for ($i = 0; $i < ob_get_level(); $i++)
    ob_end_flush();
ob_implicit_flush(1);

# JSON array header
$msg = "{\n   \"led\": [\n";
echo $msg;

# The loop
$i=0;
while (true) {

    # Rainbow gradient
    $red   = (int)(sin($i*2*pi()/128 + 0) * 127 + 128);
    $green = (int)(sin($i*2*pi()/128 + 2) * 127 + 128);
    $blue  = (int)(sin($i*2*pi()/128 + 4) * 127 + 128);
    
    # JSON data
    $msg = "      {\"red\":$red, \"green\":$green, \"blue\":$blue},\n";
    echo $msg;

    # Advance and loop gradient
    $i = $i + 2;
    if ($i==128) {
        $i = 0;
    }
    
    # 50ms between messages (20 per second)
    usleep(50000);
}
?>
