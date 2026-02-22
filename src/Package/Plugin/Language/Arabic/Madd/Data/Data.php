<?php

$jayParsedAry = [
    [
        "node" => [
            "name" => "Madd (مد)",
            "definition" => "Madd means extension or prolongation of sound when pronouncing specific Arabic letters.",
            "condition" => "Occurs when one of the Madd letters (ا، و، ي) is present.",
            "duration" => "Varies depending on the type of Madd.",
            "example" => [
                "قالوا",
                "السماء",
                "يؤمنون",
                "شَاءَ",
                "رُوحِ",
                "في سبيل",
                "آمنوا",
                "يُوضِحُ",
                "تَسُوءُ"
            ],
            "explanation" => "Madd is an important rule in Tajweed that governs the elongation of vowels in Quranic recitation."
        ],
        "parent" => null,
        "children" => [
            1,
            2
        ]
    ],
    [
        "node" => [
            "name" => "Madd Asli (مد طبيعي)",
            "definition" => "The natural elongation of a vowel sound without any external cause.",
            "condition" => "Occurs when a Madd letter (ا، و، ي) is not followed by a Hamzah or Sukoon.",
            "duration" => "2 harakat.",
            "example" => [
                "نوح",
                "قال",
                "في",
                "هو",
                "يقول",
                "يحيى",
                "سماء",
                "كبير",
                "عظيم"
            ],
            "explanation" => "It is the basic type of Madd and serves as a foundation for other types of elongation."
        ],
        "parent" => 0,
        "children" => [
        ]
    ],
    [
        "node" => [
            "name" => "Madd Far'i (مد فرعي)",
            "definition" => "A secondary extension caused by Hamzah or Sukoon.",
            "condition" => "Occurs when a Madd letter (ا، و، ي) is followed by a Hamzah (ء) or a letter with Sukoon.",
            "duration" => "Varies (2 to 6 harakat depending on the type).",
            "example" => [
                "يَشَاءُ",
                "السَّمَاءِ",
                "قُرُوءٍ",
                "يُؤْمِنُونَ",
                "أُوذُوا",
                "الضَّالِّينَ",
                "الصُّورِ",
                "يَوْمَئِذٍ",
                "الْمُفْلِحُونَ"
            ],
            "explanation" => "This type includes all elongations caused by Hamzah or Sukoon, leading to various subcategories."
        ],
        "parent" => 0,
        "children" => [
            3,
            4
        ]
    ],
    [
        "node" => [
            "name" => "Madd caused by Hamzah (مد بسبب الهمزة)",
            "definition" => "A category of Madd that occurs when a Madd letter is followed by a Hamzah (ء).",
            "condition" => "Occurs when one of the Madd letters (ا، و، ي) is directly followed by a Hamzah.",
            "duration" => "4 to 6 harakat.",
            "example" => [
                "السَّمَاءِ",
                "جَاءَ",
                "يَرَاءُونَ",
                "أُوتُوا",
                "إِيمَانًا",
                "قُرُوءٍ",
                "إِسْرَائِيلَ",
                "بِمَا أُنْزِلَ",
                "فِي أُذُنِهِ"
            ],
            "explanation" => "This category includes Madd Muttasil and Madd Munfasil, where the presence of Hamzah requires elongation."
        ],
        "parent" => 2,
        "children" => [
            6,
            7,
            8
        ]
    ],
    [
        "node" => [
            "name" => "Madd caused by Sukun (مد بسبب السكون)",
            "definition" => "A category of Madd that occurs when a Madd letter is followed by a letter with Sukoon.",
            "condition" => "Occurs when a Madd letter (ا، و، ي) is followed by a silent letter (due to a permanent Sukoon or stopping).",
            "duration" => "4 to 6 harakat depending on the type.",
            "example" => [
                "الحَاقَّةُ",
                "الطَّامَّةُ",
                "الصَّاخَّةُ",
                "الضَّالِّينَ",
                "الْجَانُّ",
                "الصُّورِ",
                "يَوْمَئِذٍ",
                "الْمُصَيِّبَاتِ",
                "الْمُفْلِحُونَ"
            ],
            "explanation" => "This category includes Madd Lazim and Madd ‘Arid Lis-Sukun, where stopping or a natural Sukoon requires elongation."
        ],
        "parent" => 2,
        "children" => [
            9,
            10,
            11,
            12,
            13
        ]
    ],
    [
        "node" => [
            "name" => "Special Madds (المدود الخاصة)",
            "definition" => "A group of non-standard Madd types that occur due to unique pronunciation rules in Tajweed.",
            "condition" => "These types do not follow the general Madd rules but occur in specific cases.",
            "duration" => "Varies depending on the type.",
            "example" => [
                "الْمُتَّكِئُونَ",
                "لِلْمُصَلِّينَ",
                "لِلَّذِينَ",
                "يُرَآؤُنَ",
                "وَسَيُجَنَّبُهَا",
                "ذُو الْعَرْشِ",
                "الْمَأْمُورِ",
                "الْمُؤْمِنُونَ",
                "الْمُسْتَقِيمَةِ"
            ],
            "explanation" => "Includes Madds like Madd Farq, Madd Shabih bil ‘Arid, and Madd Zaid, which have unique recitation rules."
        ],
        "parent" => 2,
        "children" => [
            14,
            15,
            16
        ]
    ],
    [
        "node" => [
            "name" => "Madd Badal (مد بدل)",
            "definition" => "Occurs when a Hamzah appears before a Madd letter in the same word.",
            "condition" => "The Hamzah (ء) must precede a Madd letter (ا، و، ي) in a single word.",
            "duration" => "2 harakat.",
            "example" => [
                "آمَنَ",
                "إِيمَانًا",
                "أُوتُوا",
                "إِيمَانِهِمْ",
                "آدَمَ",
                "أُوذُوا",
                "آخِرَةٌ",
                "أُوذِيَ",
                "إِيثَارًا"
            ],
            "explanation" => "Unlike other Madds, Madd Badal is always pronounced with 2 harakat in Hafs recitation."
        ],
        "parent" => 3,
        "children" => [
        ]
    ],
    [
        "node" => [
            "name" => "Madd Muttasil (مد متصل)",
            "definition" => "A necessary prolongation when a Madd letter is followed by a Hamzah in the same word.",
            "condition" => "A Madd letter (ا، و، ي) is followed by a Hamzah (ء) in the same word.",
            "duration" => "4 to 6 harakat.",
            "example" => [
                "السَّمَاءِ",
                "جَاءَ",
                "سَوَاءً",
                "شَيْءٍ",
                "إِسْرَائِيلَ",
                "يَرَاءُونَ",
                "أُولَئِكَ",
                "جِيءَ",
                "قُرُوءٍ"
            ],
            "explanation" => "Since the Hamzah appears in the same word, the Madd is prolonged more than usual (4–6 harakat)."
        ],
        "parent" => 3,
        "children" => [
        ]
    ],
    [
        "node" => [
            "name" => "Madd Munfasil (مد منفصل)",
            "definition" => "An elongation occurring when a Madd letter is at the end of a word and is followed by a Hamzah in the next word.",
            "condition" => "A Madd letter (ا، و، ي) appears at the end of a word and is followed by a Hamzah (ء) in the next word.",
            "duration" => "2 to 5 harakat (varies by recitation style).",
            "example" => [
                "بِمَا أُنْزِلَ",
                "فِي أَنْفُسِكُمْ",
                "قَالُوا آمَنَّا",
                "قَدْ أَفْلَحَ",
                "يَا أَيُّهَا",
                "فِي أُذُنِهِ",
                "يَا أَيُّهَا النَّاسُ",
                "تَحْتَهَا أَنْهَارٌ",
                "مِنَ السَّمَاءِ مَاءً"
            ],
            "explanation" => "This Madd is optional in Hafs recitation, where elongation can be 2, 4, or 5 harakat."
        ],
        "parent" => 3,
        "children" => [
        ]
    ],
    [
        "node" => [
            "name" => "Madd Lazim (مد لازم)",
            "definition" => "A mandatory prolongation of a Madd letter followed by either a Mushaddad or a letter with an original Sukoon.",
            "condition" => "Occurs when a Madd letter (ا، و، ي) is followed by a letter with a permanent Sukoon or a Shaddah.",
            "duration" => "Must be prolonged for 6 harakat.",
            "example" => [
                "الضَّالِّينَ",
                "الحَاقَّةُ",
                "الطَّامَّةُ",
                "الصَّاخَّةُ",
                "أتحَاجُّونِي",
                "الضُّحَى",
                "الصَّيْحَةُ",
                "الطُّوفَانُ",
                "الطِّيبَاتِ"
            ],
            "explanation" => "This is the strongest type of Madd and must be prolonged for 6 harakat in all cases."
        ],
        "parent" => 4,
        "children" => [
            17,
            18
        ]
    ],
    [
        "node" => [
            "name" => "Madd ‘Arid Lis-Sukun (مد عارض للسكون)",
            "definition" => "A temporary prolongation when a Madd letter appears before a letter that becomes silent due to stopping.",
            "condition" => "Occurs when a Madd letter is followed by a letter that is stopped upon with Sukoon.",
            "duration" => "Can be prolonged for 2, 4, or 6 harakat.",
            "example" => [
                "العَالَمِينَ",
                "الرَّحْمَٰنِ",
                "الرَّحِيمِ",
                "نَسْتَعِينُ",
                "يَوْمِ الدِّينِ",
                "الضَّالِّينَ",
                "يَتَسَاءَلُونَ",
                "الْمُفْلِحُونَ",
                "الْغَافِرِينَ"
            ],
            "explanation" => "Since stopping on a word makes the last letter silent, the Madd letter before it is extended for 2, 4, or 6 harakat."
        ],
        "parent" => 4,
        "children" => [
        ]
    ],
    [
        "node" => [
            "name" => "Madd Lin (مد لين)",
            "definition" => "A type of Madd that occurs when a letter of Lin (و or ي with Sukoon) is followed by a letter that becomes silent due to stopping.",
            "condition" => "Occurs when a letter of Lin (و or ي with Sukoon) is followed by a letter that becomes silent due to stopping.",
            "duration" => "Can be prolonged for 2, 4, or 6 harakat.",
            "example" => [
                "قُرَيْشٍ",
                "خَوْفٍ",
                "بَيْتٍ",
                "يَوْمٍ",
                "اللَّيْلِ",
                "حَوْلَ",
                "سَوْفَ",
                "الْبَيْنُ",
                "مَوْتِ"
            ],
            "explanation" => "This Madd is applied when stopping on a word containing a Lin letter, allowing elongation for 2, 4, or 6 harakat."
        ],
        "parent" => 4,
        "children" => [
        ]
    ],
    [
        "node" => [
            "name" => "Madd ‘Ardi (مد عرضي)",
            "definition" => "A general term for Madd that occurs due to stopping (includes Madd ‘Arid Lis-Sukun and Madd Lin).",
            "condition" => "Occurs when stopping on a word causes an elongation in the recitation.",
            "duration" => "Can be prolonged for 2, 4, or 6 harakat.",
            "example" => [
                "الْمُفْلِحُونَ",
                "الْمُصَلِّينَ",
                "الْفَاسِقِينَ",
                "الْجَاهِلِينَ",
                "الْخَاطِئِينَ",
                "الضَّالِّينَ",
                "الظَّالِمِينَ",
                "الْمُتَّقِينَ",
                "الْكَافِرِينَ"
            ],
            "explanation" => "This Madd is a broad category that includes cases where stopping on a word causes elongation."
        ],
        "parent" => 4,
        "children" => [
        ]
    ],
    [
        "node" => [
            "name" => "Madd Yaz (مد ياز)",
            "definition" => "A term not commonly used in traditional Tajweed classifications, but sometimes refers to an extra elongation in recitation.",
            "condition" => "Occurs in specific recitation styles where certain words are elongated for clarity or emphasis.",
            "duration" => "Varies depending on the style of recitation.",
            "example" => [
                "يَسۤ",
                "طه",
                "حم",
                "الم",
                "الر",
                "كهيعص",
                "المص",
                "ن والقلم",
                "قٓ والقرآن"
            ],
            "explanation" => "This type of Madd is applied in specific cases in recitation styles, particularly with the Quranic initials."
        ],
        "parent" => 4,
        "children" => [
        ]
    ],
    [
        "node" => [
            "name" => "Madd Farq (مد فرق)",
            "definition" => "A type of Madd that occurs due to Hamzatul Wasl (همزة الوصل) at the beginning of an interrogative phrase, making it necessary to differentiate the meaning.",
            "condition" => "Occurs when an interrogative Hamzah (أ) precedes a word that starts with Hamzatul Wasl (ٱ).",
            "duration" => "Must be prolonged for 6 harakat.",
            "example" => [
                "ءَآلْهَةٌ",
                "ءَآللَّهُ",
                "ءَآلذَّكَرَيْنِ",
                "ءَآلْآنَ",
                "ءَآللَّهُ خَيْرٌ",
                "ءَآللَّهُ رَبُّكُمْ",
                "ءَآللَّهُ يُرِيدُ",
                "ءَآللَّهُ أَذِنَ",
                "ءَآللَّهُ عَظِيمٌ"
            ],
            "explanation" => "The elongation occurs because the two Hamzahs meet, requiring the extension of the Madd letter to differentiate the interrogative meaning from the affirmative statement."
        ],
        "parent" => 5,
        "children" => [
        ]
    ],
    [
        "node" => [
            "name" => "Madd Shabih bil ‘Arid (مد شبيه بالعرض للسكون)",
            "definition" => "A Madd that resembles Madd ‘Arid Lissukoon but does not fully meet its conditions.",
            "condition" => "Occurs when a Madd letter is followed by a letter with an original Sukoon that is not affected by stopping.",
            "duration" => "Prolonged for 2, 4, or 6 harakat.",
            "example" => [
                "يَتَوَفَّاكُمْ مَلَكُ الْمَوْتِ",
                "وَقَالَ الَّذِينَ كَفَرُوا",
                "وَيَسْتَفْتُونَكَ",
                "إِنَّهُ لَقَوْلٌ فَصْلٌ",
                "مَالِكِ يَوْمِ الدِّينِ",
                "وَمَا خَلَقَ الذَّكَرَ وَالْأُنثَى",
                "وَلِلَّهِ الْأَمْرُ",
                "الْحَمْدُ لِلَّهِ رَبِّ الْعَالَمِينَ",
                "يَوْمَ نَقُولُ لِجَهَنَّمَ"
            ],
            "explanation" => "This Madd is similar to Madd ‘Arid Lissukoon because of the stopping condition but does not fully qualify as ‘Arid since the Sukoon is part of the word's original structure."
        ],
        "parent" => 5,
        "children" => [
        ]
    ],
    [
        "node" => [
            "name" => "Madd Zaid (مد زائد)",
            "definition" => "A type of Madd where an extra elongation is applied due to the presence of certain grammatical structures.",
            "condition" => "Occurs when a word has additional elongation due to special conditions, such as emphasis or linguistic factors.",
            "duration" => "Prolonged for 2, 4, or 6 harakat depending on recitation style.",
            "example" => [
                "وَالسَّمَاءِ وَالطَّارِقِ",
                "اللَّهُ لَا إِلَٰهَ إِلَّا هُوَ",
                "فَمَا لَهُمْ عَنِ التَّذْكِرَةِ مُعْرِضِينَ",
                "وَالنَّازِعَاتِ غَرْقًا",
                "وَالسَّابِقَاتِ سَبْقًا",
                "وَالسَّمَاءِ ذَاتِ الرَّجْعِ",
                "فَإِذَا نُقِرَ فِي النَّاقُورِ",
                "إِنَّ الْمُتَّقِينَ فِي جَنَّاتٍ وَنَهَرٍ",
                "لَا يَسْمَعُونَ فِيهَا لَغْوًا وَلَا تَأْثِيمًا"
            ],
            "explanation" => "The extra elongation comes from factors such as phonetic emphasis, special grammatical structures, or stylistic elements in Tajweed."
        ],
        "parent" => 5,
        "children" => [
        ]
    ],
    [
        "node" => [
            "name" => "Madd Lazim Kalimi (مد لازم كلمي)",
            "definition" => "A type of Madd Lazim that occurs within a word when a Madd letter is followed by either a Mushaddad or a Sakoon.",
            "condition" => "Occurs when a Madd letter is followed by a Shaddah or a permanent Sukoon in the same word.",
            "duration" => "Must be prolonged for 6 harakat.",
            "example" => [
                "الضَّالِّينَ",
                "الصَّاخَّةُ",
                "الطَّامَّةُ",
                "الحَاقَّةُ",
                "أتحَاجُّونِي",
                "الصَّيْحَةُ",
                "الطُّوفَانُ",
                "الضُّحَى",
                "الطِّيبَاتِ"
            ],
            "explanation" => "Since a Madd letter is followed by a Mushaddad or Sukoon, it is necessary to extend it for 6 harakat."
        ],
        "parent" => 9,
        "children" => [
            19,
            20
        ]
    ],
    [
        "node" => [
            "name" => "Madd Lazim Harfi (مد لازم حرفي)",
            "definition" => "A type of Madd Lazim that occurs in the Quranic initials (Huroof Muqatta’ah) where a Madd letter is followed by either a Mushaddad or a Sakoon.",
            "condition" => "Occurs in the beginning letters of Surahs where the letter with Madd is followed by a silent or Mushaddad letter.",
            "duration" => "Must be prolonged for 6 harakat.",
            "example" => [
                "الم",
                "المر",
                "طسم",
                "كهيعص",
                "حم عسق",
                "المص",
                "الر",
                "يس",
                "ص"
            ],
            "explanation" => "Since the Madd letter in the Quranic initials is followed by either a Mushaddad or a silent letter, it must be prolonged for 6 harakat."
        ],
        "parent" => 9,
        "children" => [
            21,
            22
        ]
    ],
    [
        "node" => [
            "name" => "Madd Lazim Kalimi Mushaddad (مد لازم كلمي مثقل)",
            "definition" => "A type of Madd Lazim where a letter with a Madd is followed by a Mushaddad letter within a single word.",
            "condition" => "Occurs when a Madd letter is followed by a Shaddah ( ّ ) in the same word.",
            "duration" => "Must be prolonged for 6 harakat.",
            "example" => [
                "الضَّالِّينَ",
                "الصَّاخَّةُ",
                "الطَّامَّةُ",
                "الحَاقَّةُ",
                "أتحَاجُّونِي",
                "الصَّيْحَةُ",
                "الطُّوفَانُ",
                "الضُّحَى",
                "الطِّيبَاتِ"
            ],
            "explanation" => "The Madd occurs because the letter before the Shaddah has a Madd, making it necessary to extend it for 6 harakat."
        ],
        "parent" => 17,
        "children" => [
        ]
    ],
    [
        "node" => [
            "name" => "Madd Lazim Kalimi Mukhaffaf (مد لازم كلمي مخفف)",
            "definition" => "A type of Madd Lazim where a Madd letter is followed by a Sukoon within a single word, without a Shaddah.",
            "condition" => "Occurs when a Madd letter is followed by a Sukoon ( ْ ) in the same word.",
            "duration" => "Must be prolonged for 6 harakat.",
            "example" => [
                "ءَآلْـٰٔنَ",
                "ءَآلْـٰٔنَ وَقَدْ كُنتُم",
                "ءَآلْـٰٔنَ وَقَدْ عَصَيْتَ",
                "ءَآلْـٰٔنَ أَنْتَ",
                "ءَآلْـٰٔنَ فَإِنَّ",
                "ءَآلْـٰٔنَ أَنَا",
                "ءَآلْـٰٔنَ وَقَدْ",
                "ءَآلْـٰٔنَ كُنتَ",
                "ءَآلْـٰٔنَ مَعِي"
            ],
            "explanation" => "This type is extremely rare in the Quran, appearing only in the word (ءَآلْـٰٔنَ). The Madd is extended because of the sukoon following the Madd letter."
        ],
        "parent" => 17,
        "children" => [
        ]
    ],
    [
        "node" => [
            "name" => "Madd Lazim Harfi Mushaddad (مد لازم حرفي مثقل)",
            "definition" => "A type of Madd Lazim that occurs in certain Quranic initials (Huroof Muqatta’ah) where a Madd letter is followed by a Mushaddad letter.",
            "condition" => "Occurs in the opening letters of Surahs, where a letter with Madd is followed by a Shaddah.",
            "duration" => "Must be prolonged for 6 harakat.",
            "example" => [
                "الم",
                "المر",
                "طسم",
                "كهيعص",
                "حم عسق",
                "المص",
                "الر",
                "يس",
                "ص"
            ],
            "explanation" => "The elongation occurs because the individual letters in the Quranic initials contain Madd letters followed by a Mushaddad letter."
        ],
        "parent" => 18,
        "children" => [
        ]
    ],
    [
        "node" => [
            "name" => "Madd Lazim Harfi Mukhaffaf (مد لازم حرفي مخفف)",
            "definition" => "A type of Madd Lazim that occurs in certain Quranic initials (Huroof Muqatta’ah) where a Madd letter is followed by a Sukoon, without a Shaddah.",
            "condition" => "Occurs in the opening letters of Surahs, where a letter with Madd is followed by a silent letter.",
            "duration" => "Must be prolonged for 6 harakat.",
            "example" => [
                "ق",
                "ن",
                "ص",
                "الر",
                "الم",
                "طس",
                "حم",
                "كهيعص",
                "يس"
            ],
            "explanation" => "The elongation occurs because the individual letters in the Quranic initials contain Madd letters followed by a silent letter (sukoon), making it necessary to prolong them for 6 harakat."
        ],
        "parent" => 18,
        "children" => [
        ]
    ]
];

