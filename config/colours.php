<?php

// Board colours and HPL colours — from the ERP (Inventory → Hisoon library, "Matches" and
// "Edge bands", 21 November 2026). The code is the ERP code, so sales match it 1:1 in the
// CRM, the Sales Tool and Hisoon. 'hex' is only a guide for the screen; when a real photo
// of the board exists, put it in public/images/colours/<code>.webp and set 'image'.
// Every board colour comes on marine plywood and on particle board (owner, 21 Nov 2026),
// so the website shows one list of board colours — never "melamine" vs "plywood" colours.
// HPL is a different material with its own colours and matching edge bands.
// No prices here, ever.
return [
    'board' => [
        ['code' => 'MP.60.MATT.FSI', 'name' => 'Real White', 'finish' => 'matt', 'hex' => '#f4f3ef'],
        ['code' => 'MP.60.HG.FSI', 'name' => 'White', 'finish' => 'gloss', 'hex' => '#fbfbfa'],
        ['code' => 'MP.005-960M', 'name' => 'Latte', 'finish' => 'matt', 'hex' => '#d8c7ad'],
        ['code' => 'MP.005-960HG', 'name' => 'Latte', 'finish' => 'gloss', 'hex' => '#dccbb1'],
        ['code' => 'MP.7007-4', 'name' => 'Light Mocha', 'finish' => 'matt', 'hex' => '#b49a82'],
        ['code' => 'MP.7007-6', 'name' => 'Grey', 'finish' => 'matt', 'hex' => '#a6a6a2'],
        ['code' => 'MP.9013-1', 'name' => 'Dark Grey', 'finish' => 'matt', 'hex' => '#4d4f51'],
        ['code' => 'MP.6023H-5', 'name' => 'Slate', 'finish' => 'matt', 'hex' => '#5f6366'],
        ['code' => 'MP.Black HG', 'name' => 'Noir', 'finish' => 'gloss', 'hex' => '#141414'],
        ['code' => 'MP.006-129M', 'name' => 'Old Rose', 'finish' => 'matt', 'hex' => '#c9a3a0'],
        ['code' => 'MP.61M', 'name' => 'Pastel Blue', 'finish' => 'matt', 'hex' => '#a9c0d3'],
        ['code' => 'MP.M7001-1', 'name' => 'Dark Blue', 'finish' => 'matt', 'hex' => '#25324a'],
        ['code' => 'MP.9013-21M', 'name' => 'Emerald', 'finish' => 'matt', 'hex' => '#1f5a46'],
        ['code' => 'MP.9013-21HG', 'name' => 'Emerald', 'finish' => 'gloss', 'hex' => '#216048'],
        ['code' => 'MP.9093M', 'name' => 'Ruby', 'finish' => 'matt', 'hex' => '#7c1f2c'],
        ['code' => 'MP.9093HG', 'name' => 'Ruby', 'finish' => 'gloss', 'hex' => '#86202f'],
        ['code' => 'MP.8864-3', 'name' => 'Calacatta Marble', 'finish' => 'stone', 'hex' => 'linear-gradient(135deg,#f6f4f0 0%,#ebe7e0 45%,#a8a29a 47%,#f2efe9 50%,#e9e5de 100%)'],
        ['code' => 'MP.032.HG CALACATA GOLD', 'name' => 'Calacatta Gold', 'finish' => 'gloss', 'hex' => 'linear-gradient(135deg,#f7f4ee 0%,#efe8da 44%,#c9a96a 46%,#f4efe6 49%,#ece6db 100%)'],
        ['code' => 'MP.358.HG', 'name' => 'Calacatta Quartz', 'finish' => 'gloss', 'hex' => 'linear-gradient(135deg,#f5f5f3 0%,#e7e6e3 45%,#9c9b98 47%,#f1f0ee 50%,#e6e5e2 100%)'],
        ['code' => 'MP.9065H-10Y', 'name' => 'Midnight Marble', 'finish' => 'stone', 'hex' => 'linear-gradient(135deg,#1d1f22 0%,#2b2e32 45%,#cfcfcf 47%,#24272b 50%,#1b1d20 100%)'],
        ['code' => 'MP.DL3062', 'name' => 'Basalt Stone', 'finish' => 'stone', 'hex' => 'radial-gradient(circle at 30% 30%,#7a7774,#4c4a48 70%)'],
        ['code' => 'MP.MF9073H-4', 'name' => 'Black Granite', 'finish' => 'stone', 'hex' => 'radial-gradient(circle at 30% 30%,#3a3a3a,#111 70%)'],
        ['code' => 'MP.Y2151-1', 'name' => 'Maple Wood', 'finish' => 'wood', 'hex' => 'linear-gradient(90deg,#d9b98c,#cfae80,#dcbf94,#c9a777)'],
        ['code' => 'MP.Y2146', 'name' => 'Cedar', 'finish' => 'wood', 'hex' => 'linear-gradient(90deg,#c08a5a,#b57f50,#c69264,#ae784b)'],
        ['code' => 'AJAX-ACACIA', 'name' => 'Acacia AJAX', 'finish' => 'wood', 'hex' => 'linear-gradient(90deg,#b98a5b,#a87a4d,#c19366,#9f7146)'],
        ['code' => 'MP.Y2118', 'name' => 'Hackberry', 'finish' => 'wood', 'hex' => 'linear-gradient(90deg,#b7a48a,#a8957b,#bfad93,#a08c72)'],
        ['code' => 'MP.YC123', 'name' => 'Ash Brown', 'finish' => 'wood', 'hex' => 'linear-gradient(90deg,#8f7a64,#806c57,#98826b,#77634f)'],
        ['code' => 'MP.Y2152', 'name' => 'Brown Teak', 'finish' => 'wood', 'hex' => 'linear-gradient(90deg,#8a5d3b,#7b5133,#946542,#70492d)'],
        ['code' => 'MP.Y2150', 'name' => 'Dark Teak', 'finish' => 'wood', 'hex' => 'linear-gradient(90deg,#6e4a30,#5f3f28,#775036,#553823)'],
        ['code' => 'MP.Y2154', 'name' => 'Brown Walnut', 'finish' => 'wood', 'hex' => 'linear-gradient(90deg,#6b4a36,#5c3f2e,#74513b,#523828)'],
        ['code' => 'MP.MF2002-8', 'name' => 'Tropical Walnut', 'finish' => 'wood', 'hex' => 'linear-gradient(90deg,#5d3f2c,#4f3525,#664631,#472f21)'],
        ['code' => 'MP.MF2009H-2', 'name' => 'Mahogany', 'finish' => 'wood', 'hex' => 'linear-gradient(90deg,#6b2f22,#5c281d,#753526,#52231a)'],
        ['code' => 'MP.Y2112', 'name' => 'Dark Cherry', 'finish' => 'wood', 'hex' => 'linear-gradient(90deg,#5a2a22,#4c231c,#633026,#431f19)'],
    ],


    // HPL on plywood — each with its own 22 mm edge band (code RF.<same number>).
    'hpl' => [
        ['code' => 'HPL.C6006-2', 'name' => 'Matt White', 'finish' => 'matt', 'hex' => '#f2f1ec'],
        ['code' => 'HPL.C6006-7', 'name' => 'High Gloss White', 'finish' => 'gloss', 'hex' => '#fbfbfa'],
        ['code' => 'HPL.C6016-2', 'name' => 'Matt Black', 'finish' => 'matt', 'hex' => '#1b1b1b'],
        ['code' => 'HPL.C6077-2', 'name' => 'Textured Linen Grey', 'finish' => 'matt', 'hex' => 'repeating-linear-gradient(45deg,#9d9b96 0 2px,#a7a5a0 2px 4px)'],
        ['code' => 'HPL.F0902', 'name' => 'Steel Grey', 'finish' => 'matt', 'hex' => '#6f7377'],
        ['code' => 'HPL.C6159-2', 'name' => 'Brushed Silver', 'finish' => 'metal', 'hex' => 'repeating-linear-gradient(90deg,#c7c9cb 0 1px,#b7b9bb 1px 3px)'],
        ['code' => 'HPL.3026', 'name' => 'Brushed Aluminium', 'finish' => 'metal', 'hex' => 'repeating-linear-gradient(90deg,#bfc2c4 0 1px,#aeb1b3 1px 3px)'],
        ['code' => 'HPL.2922', 'name' => 'Oxidized Metal', 'finish' => 'metal', 'hex' => 'radial-gradient(circle at 30% 40%,#8a6a4a,#4a3a2c 70%)'],
        ['code' => 'HPL.7676', 'name' => 'Copper Marble', 'finish' => 'stone', 'hex' => 'linear-gradient(135deg,#3b3431 0%,#4a403b 45%,#b07c55 47%,#413834 50%,#352e2b 100%)'],
        ['code' => 'HPL.C6171-7', 'name' => 'Speckled Granite', 'finish' => 'stone', 'hex' => 'radial-gradient(circle at 30% 30%,#9a9894,#6d6b68 70%)'],
        ['code' => 'HPL.C6155-2', 'name' => 'Stone Ash', 'finish' => 'stone', 'hex' => '#b8b2a8'],
        ['code' => 'HPL.C6100-2', 'name' => 'White Washed Ash', 'finish' => 'wood', 'hex' => 'linear-gradient(90deg,#e4ddd2,#d9d1c4,#e8e1d7,#d3cabd)'],
        ['code' => 'HPL.C6133-4', 'name' => 'Frosted Elm', 'finish' => 'wood', 'hex' => 'linear-gradient(90deg,#d6cbbb,#c9bdab,#dbd0c1,#c2b5a2)'],
        ['code' => 'HPL.C6138-4', 'name' => 'Light Elm', 'finish' => 'wood', 'hex' => 'linear-gradient(90deg,#d2b48c,#c4a67e,#d8bb94,#bd9f77)'],
        ['code' => 'HPL.C6040-2', 'name' => 'Natural Beech', 'finish' => 'wood', 'hex' => 'linear-gradient(90deg,#dcb98f,#cfab80,#e1c096,#c8a478)'],
        ['code' => 'HPL.C6057-5', 'name' => 'Blonde Oak', 'finish' => 'wood', 'hex' => 'linear-gradient(90deg,#d8bf97,#cab18a,#dec59e,#c4aa82)'],
        ['code' => 'HPL.7388', 'name' => 'Ash Grey Oak', 'finish' => 'wood', 'hex' => 'linear-gradient(90deg,#a49b8f,#968d81,#ada498,#8f8679)'],
        ['code' => 'HPL.C6089-2', 'name' => 'Grey Oak', 'finish' => 'wood', 'hex' => 'linear-gradient(90deg,#9b938a,#8d857c,#a39b92,#867e75)'],
        ['code' => 'HPL.7728', 'name' => 'Nordic Ash', 'finish' => 'wood', 'hex' => 'linear-gradient(90deg,#cbbfae,#bdb1a0,#d1c5b4,#b6aa98)'],
        ['code' => 'HPL.9066', 'name' => 'Golden Teak', 'finish' => 'wood', 'hex' => 'linear-gradient(90deg,#b27d45,#a3713c,#bb864d,#9b6a36)'],
        ['code' => 'HPL.7509', 'name' => 'Classic Teak', 'finish' => 'wood', 'hex' => 'linear-gradient(90deg,#8e5e36,#7f532f,#97673d,#774c2a)'],
        ['code' => 'HPL.C6073-3', 'name' => 'Warm Cherry', 'finish' => 'wood', 'hex' => 'linear-gradient(90deg,#8d4a32,#7e412c,#965238,#753c28)'],
        ['code' => 'HPL.7717', 'name' => 'Smoked Walnut', 'finish' => 'wood', 'hex' => 'linear-gradient(90deg,#5b4334,#4e392c,#634a3a,#463326)'],
        ['code' => 'HPL.T5239', 'name' => 'Shadow Walnut', 'finish' => 'wood', 'hex' => 'linear-gradient(90deg,#4d3a2e,#413126,#554034,#3a2b21)'],
        ['code' => 'HPL.F9398', 'name' => 'Dark Walnut', 'finish' => 'wood', 'hex' => 'linear-gradient(90deg,#4a3326,#3e2b20,#523a2c,#37261c)'],
        ['code' => 'HPL.W7960', 'name' => 'Ebony Wood', 'finish' => 'wood', 'hex' => 'linear-gradient(90deg,#2c241f,#231d19,#332a24,#1e1915)'],
    ],
];
