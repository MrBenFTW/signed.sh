<?php
// Made by Quix
require 'config.php';
$apps = array_filter(glob('uploads/*'), 'is_dir');
foreach($apps as $app){
    $app = substr($app, 8);
    mkdir('apps/' . $app);
    $cert = file_get_contents('uploads/' . $app . '/cert.txt');
    if($remove_cert = true || $remove_dir = true)
        unlink('uploads/' . $app . '/cert.txt');
    $remove_icon = false;
    if($remove_icon = true || $remove_dir = true)
    	rename('uploads/' . $app . '/' . $app . '.png', 'apps/' . $app . '/' . $app . '.png');
    else
    	copy('uploads/' . $app . '/' . $app . '.png', 'apps/' . $app . '/' . $app . '.png');
    if($remove_ipa = true || $remove_dir = true)
    	rename('uploads/' . $app . '/' . $app . '.ipa', 'apps/' . $app . '/' . $app . '_' . $cert . '.ipa');
    else
        copy('uploads/' . $app . '/' . $app . '.ipa', 'apps/' . $app . '/' . $app . '_' . $cert . '.ipa');
    if($remove_dir = true){
    	rmdir('uploads/' . $app);
    }
    file_put_contents('apps/' . $app . '/' . $app . '_' . $cert . '.plist', '<?xml version="1.0" encoding="UTF-8"?>
    <!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
    <plist version="1.0">
    <dict>
        <key>items</key>
        <array>
            <dict>
                <key>assets</key>
                <array>
                    <dict>
                        <key>kind</key>
                        <string>software-package</string>
                        <key>url</key>
                        <string>https://app.signed.sh/apps/' . $app . '/' . $app . '_' . $cert . '.ipa</string>
                    </dict>
                </array>
                <key>metadata</key>
                <dict>
                    <key>bundle-identifier</key>
                    <string>6578A826QL.com.serverservers.*</string>
                    <key>bundle-version</key>
                    <string>1.0</string>
                    <key>kind</key>
                    <string>software</string>
                    <key>title</key>
                    <string>' . $app . '</string>
                </dict>
            </dict>
        </array>
    </dict>
    </plist>');
}
