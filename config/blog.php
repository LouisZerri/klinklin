<?php

/*
|--------------------------------------------------------------------------
| Articles & conseils
|--------------------------------------------------------------------------
| Source unique des articles du blog : utilisée à la fois par le carrousel
| de la page d'accueil et par les pages de détail (BlogController).
| Chaque clé est le slug utilisé dans l'URL /conseils/{slug}.
*/

return [

    '5-erreurs-a-eviter-lavage' => [
        'tag' => 'Nouveau',
        'title' => "5 erreurs à éviter quand vous lavez vos vêtements",
        'excerpt' => "Apprenez à ne plus abîmer vos habits : surdosage de lessive, tri des couleurs, cycles trop agressifs…",
        'image' => '/images/erreurs.png',
        'lead' => "Un lavage maison mal maîtrisé peut réduire la durée de vie de vos vêtements de moitié. Voici les cinq erreurs les plus fréquentes, et comment les éviter.",
        'body' => [
            ['heading' => '1. Surdoser la lessive', 'text' => "Plus de lessive ne signifie pas plus de propreté. Un excès de produit laisse des résidus dans les fibres, irrite la peau et encrasse la machine. Respectez les doses indiquées, et réduisez-les si votre eau est douce."],
            ['heading' => '2. Négliger le tri des couleurs', 'text' => "Un seul vêtement neuf qui déteint peut ruiner toute une machine. Séparez les blancs, les couleurs claires et les couleurs foncées, surtout pour les premiers lavages."],
            ['heading' => '3. Choisir un cycle trop agressif', 'text' => "Les programmes intensifs et les essorages élevés usent prématurément les tissus délicats. Adaptez toujours le cycle à la matière : un lavage doux suffit dans la majorité des cas."],
            ['heading' => '4. Ignorer les étiquettes', 'text' => "Les symboles d'entretien ne sont pas décoratifs. Ils indiquent la température maximale, le mode de séchage et la compatibilité au repassage. Les lire évite bien des catastrophes."],
            ['heading' => '5. Laisser le linge humide trop longtemps', 'text' => "Le linge oublié dans le tambour développe des odeurs de moisi en quelques heures. Étendez-le rapidement après la fin du cycle."],
        ],
    ],

    'lavage-ecoresponsable-klinklin' => [
        'tag' => 'Nouveau',
        'title' => "Lavage écoresponsable : comment KLIN KLIN réduit son impact environnemental",
        'excerpt' => "Découvrez nos engagements pour un linge propre grâce à des produits respectueux, une eau maîtrisée...",
        'image' => '/images/lavage.png',
        'lead' => "Prendre soin de votre linge ne devrait pas se faire au détriment de la planète. Voici comment nous limitons l'empreinte de chaque lavage.",
        'body' => [
            ['heading' => 'Des lessives biodégradables', 'text' => "Nous utilisons exclusivement des produits écologiques, sans phosphates ni substances irritantes, qui se décomposent naturellement sans polluer les eaux usées."],
            ['heading' => "Une consommation d'eau maîtrisée", 'text' => "Nos machines professionnelles optimisent le volume d'eau et regroupent les commandes pour éviter le gaspillage, là où plusieurs lavages domestiques seraient nécessaires."],
            ['heading' => 'Moins de trajets, moins de CO₂', 'text' => "En mutualisant les collectes et les livraisons sur des tournées optimisées, nous réduisons le nombre de kilomètres parcourus par rapport à des déplacements individuels au pressing."],
        ],
    ],

    'comment-detacher-un-vetement' => [
        'tag' => 'Conseil',
        'title' => "Comment détacher un vêtement efficacement ?",
        'excerpt' => "Méthodes naturelles et efficaces pour enlever les taches sans abîmer vos tissus préférés.",
        'image' => 'https://picsum.photos/seed/detache/600/300',
        'lead' => "Une tache traitée à temps part presque toujours. La clé : agir vite et choisir la bonne méthode selon la nature de la tache.",
        'body' => [
            ['heading' => 'Agir immédiatement', 'text' => "Tamponnez sans frotter pour absorber le surplus, puis rincez à l'eau froide. L'eau chaude fixe la plupart des taches, notamment celles de sang et de protéines."],
            ['heading' => 'Les bons réflexes par type de tache', 'text' => "Le gras se traite avec du savon de Marseille ou du liquide vaisselle ; le vin avec du vinaigre blanc ; l'herbe avec un peu d'alcool ménager. Testez toujours sur une zone cachée."],
            ['heading' => 'Quand confier la pièce à un professionnel', 'text' => "Pour les textiles délicats, la soie ou les taches anciennes, mieux vaut éviter les manipulations hasardeuses : un nettoyage à sec professionnel préserve la matière."],
        ],
    ],

    'choisir-la-bonne-lessive' => [
        'tag' => 'Astuce',
        'title' => "Choisir la bonne lessive pour votre linge",
        'excerpt' => "Lessive bio, liquide ou en poudre ? Voici comment choisir celle qui respecte vos textiles et l'environnement.",
        'image' => 'https://picsum.photos/seed/lessive/600/300',
        'lead' => "Liquide, poudre ou capsules : chaque format a ses forces. Le bon choix dépend de votre linge, de votre eau et de vos priorités.",
        'body' => [
            ['heading' => 'Poudre ou liquide ?', 'text' => "La poudre est plus efficace sur le blanc et les taches incrustées, mais peut laisser des traces en eau froide. Le liquide se dissout mieux à basse température et convient aux couleurs."],
            ['heading' => "Privilégier l'écologique", 'text' => "Les lessives labellisées limitent les agents chimiques agressifs. Plus douces pour la peau et pour l'environnement, elles conviennent particulièrement aux peaux sensibles."],
            ['heading' => 'Doser selon son eau', 'text' => "En eau calcaire, augmentez légèrement la dose ou ajoutez un anticalcaire. En eau douce, réduisez : vous économiserez du produit sans perdre en efficacité."],
        ],
    ],

    'plier-vetements-comme-un-pro' => [
        'tag' => 'Astuces',
        'title' => "Comment plier vos vêtements comme un pro",
        'excerpt' => "Découvrez des techniques simples pour optimiser votre rangement et éviter les plis.",
        'image' => 'https://picsum.photos/seed/plier/600/300',
        'lead' => "Un pliage soigné fait gagner de la place, limite le repassage et donne à vos placards des allures de boutique.",
        'body' => [
            ['heading' => 'Le pliage vertical', 'text' => "Rangés debout plutôt qu'empilés, les vêtements restent visibles d'un coup d'œil et ne s'écrasent pas sous le poids des autres. Idéal pour les tiroirs."],
            ['heading' => 'Plier selon la matière', 'text' => "Les mailles se plient pour éviter qu'elles ne se déforment sur cintre ; les chemises et vestes se suspendent pour garder leur tombé."],
            ['heading' => 'Repasser avant de ranger', 'text' => "Un vêtement plié encore tiède après repassage conserve mieux sa forme. Laissez-le refroidir à plat quelques minutes avant de le ranger."],
        ],
    ],

    'routine-linge-5-etapes' => [
        'tag' => 'Organisation',
        'title' => "Routine linge : 5 étapes pour ne plus rien oublier",
        'excerpt' => "Une checklist pour ne plus louper aucune étape du lavage au rangement.",
        'image' => 'https://picsum.photos/seed/routine/600/300',
        'lead' => "Une routine bien rodée transforme la corvée du linge en réflexe rapide. Voici les cinq étapes à enchaîner sans y penser.",
        'body' => [
            ['heading' => '1. Trier en amont', 'text' => "Installez plusieurs bacs (blanc, couleur, délicat) pour que le tri se fasse au fil de la semaine, sans effort le jour du lavage."],
            ['heading' => '2. Vérifier les poches et les étiquettes', 'text' => "Un mouchoir oublié peut ruiner une machine. Un coup d'œil aux étiquettes évite les mauvaises surprises de température."],
            ['heading' => '3. Lancer au bon moment', 'text' => "Programmez la machine pour qu'elle se termine quand vous pouvez étendre immédiatement : pas de linge oublié, pas d'odeurs."],
            ['heading' => '4. Sécher correctement', 'text' => "Privilégiez l'air libre quand c'est possible ; à défaut, choisissez le bon programme sèche-linge selon la matière."],
            ['heading' => '5. Plier et ranger sans attendre', 'text' => "Le linge plié à chaud se froisse moins. Rangez dans la foulée pour ne pas accumuler les piles."],
        ],
    ],

    'faut-il-trier-les-couleurs' => [
        'tag' => 'Mythe ou vérité',
        'title' => "Faut-il vraiment trier les couleurs ?",
        'excerpt' => "On vous explique pourquoi ce réflexe évite bien des catastrophes (et du rose involontaire).",
        'image' => 'https://picsum.photos/seed/couleurs/600/300',
        'lead' => "Oui, mais pas pour les raisons que l'on croit toujours. Le tri des couleurs reste utile, surtout dans certains cas précis.",
        'body' => [
            ['heading' => 'Le risque du dégorgement', 'text' => "Les tissus neufs et les couleurs vives libèrent de l'excédent de teinture lors des premiers lavages. Mélangés à du blanc, ils le ternissent ou le colorent."],
            ['heading' => 'La température compte autant', 'text' => "Plus l'eau est chaude, plus les couleurs dégorgent. Laver à froid limite fortement le risque, même avec un tri imparfait."],
            ['heading' => 'En pratique', 'text' => "Séparez au minimum les blancs des couleurs, et isolez les pièces neuves pour leurs premiers lavages. Le reste peut souvent partir ensemble à basse température."],
        ],
    ],

    'sechage-air-libre-vs-machine' => [
        'tag' => 'Comparatif',
        'title' => "Séchage à l'air libre vs. machine : le match",
        'excerpt' => "Impact écologique, rapidité, tenue des tissus : on compare pour vous les deux méthodes.",
        'image' => 'https://picsum.photos/seed/sechage/600/300',
        'lead' => "Étendoir ou sèche-linge ? Chaque méthode a ses avantages. Voici comment choisir selon la situation.",
        'body' => [
            ['heading' => "L'air libre : doux et économique", 'text' => "Le séchage naturel ne consomme aucune énergie et préserve les fibres comme l'élasticité des vêtements. Son inconvénient : il est lent et dépend de la météo."],
            ['heading' => 'La machine : rapide et pratique', 'text' => "Le sèche-linge offre un linge prêt en moins d'une heure, particulièrement utile en hiver. En contrepartie, il consomme de l'énergie et sollicite davantage les tissus."],
            ['heading' => 'Le bon compromis', 'text' => "Séchez à l'air libre dès que possible, et réservez la machine aux pièces robustes ou aux urgences. Vos vêtements dureront plus longtemps et votre facture s'allègera."],
        ],
    ],

];
