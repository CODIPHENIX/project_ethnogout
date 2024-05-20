<?php


session_start();


require_once __DIR__ . "/../includes/header.inc.php";
require_once __DIR__ . "/../includes/part/nav.part.inc.php";
?>
<main>
    <section class="t_rct">
        <h1>
            Title H1
        </h1>
        <div class="note">
            <div> note</div>
            <div class="avis"> n avis</div>
        </div>
        <div class="img_rct">
            <img src="" alt="">
        </div>
        <ul class="info_rct">
            <li>
                <div class="icon_r"><i class="fi fi-rr-alarm-clock"></i></div>
                <div>diffilculter</div>
            </li>
            <li>
                <div class="icon_r"><i class="fi fi-rs-hat-chef"></i></div>
                <div>min</div>

            </li>
            <li>
                <div class="icon_r"><i
                        class=
                        "fi fi-rr-heart"
                    ></i></div>

            </li>


        </ul>
        <div class="s_ing">
            <h3>Ingredient</h3>
            <ul class="ingredient">
                <li>quia</li>
                <li>ipsum</li>
                <li>dolorem</li>
                <li>qui</li>
                <li>quisquam</li>
                <li>est</li>
                <li>porro</li>
            </ul>
        </div>

        <ul class="time_r">
            <li><h3>Preparation:</h3></li>
            <li>Preparation<span>10min</span></li>
            <li>Cuisson<span>30min</span></li>
        </ul>

        <ul class="etape_r">
            <li><h3>1</h3></li>
            <li>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione</li>
            <li><h3>2</h3></li>
            <li>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione</li>
        </ul>
    </section>
    <section class="b_rct">
        <div class="part1">
            <div class="usr_cmt">
                <h3>
                    Commentaire
                </h3>
                <form>
                    <input type="text" name="comment" class="comment">
                    <p>note</p>
                    <button type="submit" class="sent_cmt">envoyer</button>
                </form>
            </div>
            <div class="usr_cmt">
                <ul class="avis_usrs">
                    <div class="avatar_user">
                        <li class="avatar_img"><img src="" alt="avatar" ></li>
                        <ii>Piere</ii>
                    </div>
                    <div class="comment_user">
                        <li><p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et </p></li>
                        <li>note</li>
                    </div>

                </ul>

            </div>

            <div class="s_rct_smr">
                <h3>
                    Recette similaires
                </h3>
                <div class="grid grid_rs">
                    <ul class="item ctnt_rs">
                        <li class="img_p "><img src="" alt="image recette"></li>
                        <li class="title">Title</li>
                    </ul>
                    <ul class="item ctnt_rs">
                        <li class="img_p "><img src="" alt="image recette"></li>
                        <li class="title">Title</li>
                    </ul>
                    <ul class="item ctnt_rs">
                        <li class="img_p "><img src="" alt="image recette"></li>
                        <li class="title">Title</li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="part2">
            <h3>
                Restaurent a proximiter
            </h3>
            <div class="grid rest_p">
                <ul class="item ctnt_rp">
                    <li class="img_p "><img src="" alt="image recette"></li>
                    <li class="title">Title</li>
                    <li>address</li>
                </ul>
                <ul class="item ctnt_rp">
                    <li class="img_p "><img src="" alt="image recette"></li>
                    <li class="title">Title</li>
                    <li>address</li>
                </ul>
                <ul class="item ctnt_rp">
                    <li class="img_p "><img src="" alt="image recette"></li>
                    <li class="title">Title</li>
                    <li>address</li>
                </ul>
            </div>

        </div>

    </section>


</main>
