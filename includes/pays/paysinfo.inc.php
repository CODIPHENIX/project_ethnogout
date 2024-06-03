<?php

require_once __DIR__ . "/../../includes/header.inc.php";
require_once __DIR__ . "/../../includes/part/nav.part.inc.php";
?>
    <main>
        <section class="part paysh">
            <h1><?php echo htmlspecialchars($infopays['nompays']); ?></h1>
            <p><?php echo htmlspecialchars($infopays['description']); ?></p>
        </section>

        <section class="myrecette">
            <div class="grid_myr">
                <?php if(is_array($recettes)):?>
                    <?php foreach ($recettes as $recette): ?>
                        <ul class="user_rct">
                            <li class="img_myrct">
                                <a href="./recette.php?id=<?php echo htmlspecialchars($recette['idrecette']); ?>" >
                                    <img src="<?php echo htmlspecialchars($recette['image_recette']); ?>" alt="image recette">
                                </a>
                            </li>
                            <li class="title"><?php echo htmlspecialchars($recette['titrerecette']); ?></li>
                            <li>
                                <div class="stars noteDonner">
                                    <?php if (intval($recette['moyenne_note'])): ?>
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class=" fa <?= $i <= round(intval($recette['moyenne_note'])) ? 'star checked fa-star ' : 'fa-star' ?>"></i>
                                        <?php endfor; ?>
                                    <?php endif; ?>
                                </div>
                            </li>

                        </ul>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucune recette trouvé.</p>
                <?php endif; ?>
            </div>

        </section>
    </main>
<?php

require_once __DIR__ . "/../../includes/footer.inc.php"
?>