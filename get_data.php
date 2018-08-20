<?php

$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhX2FlYSI6WyJeLiokOjpeLiokIl0sImlhdCI6MTUzMjk0MTg2NX0.YQDEIQAjNhuFCFj5kkaN3AipQto_HlSMUzbLQlCViFjwJ_6gU3gX08oG4YLw6Ys6MJn4ufkrTm2GMPEiOGxGyI3TCbzQrFrMyDek4ZgVgbPqxTylleo-0L3DelAfyjqG8RYfimcPngnqocTwgYr6pAQ7m04pV9v6R5vJ0PKkR6Y-avH4rFaYdMBHGjH_So0dEwjI8neaXredfTc1O-0zznzd5hMOtxRBGQBtkCqUUFihTpbC0tGnxinPq8d2geZ2oyKw0so-uSD3Vgfn1YE7ZgSZjiHwgGAdzNjmhkRTIvd2Un40A1106xxaUlbkfifLwpOl8bkKHMu-wEDSfBZbt_Dj_WQKmYQpJ144VM5Paulm6OowOajojeYsJBzVMvIUn840snvxEphB5BMRjaMMSpcObGz9GuVW2VeMbfb6TZhYuFp5BKQZEIguegFzDM0DNLZRj7VPjDfVjNqoUWLIhdrOu1ry-MC8kbF3iK6NkCbMk6OqGFGrjIQ_DXE7cQq6RgK74M7_z9ozs3y8x8Iz8qGB_urI_FDmpanfYyBh9yX5FMcwVdDvxK-hSSiloS9T9QGUfYEB7awaRklTB9vyv6IEGrH2fRw9t-Khxmo6cZ0WSVHVwGUQIqQAocK46Y1Q117J92FBpf2-julfdJMzEW7lmSKAClXUxm2ojobBgpc";

$authorization = "Authorization: Bearer ".$token;

$curl = 
curl_init("https://sviluppo.api.seewebiot.com/appengine/v1/sviluppo/devices/kWZpqnNDTACSXpgq13fpvg/interfaces/com.api.sviluppo.Sensori/");

header('Content-Type: application/json');

curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));

curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //otherwise it returns 1

$result = curl_exec($curl);

$json_output = json_decode($result, true);

foreach($json_output as $key){
  foreach($key as $k => $v){
    echo $k.": ";
    echo $v["value"];
    echo "\n";
  }
}


?>
