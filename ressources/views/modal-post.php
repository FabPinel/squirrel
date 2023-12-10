 <div class="modal hidden">
     <button class="close-modal">&times;</button>
     <form action="/ressources/controller/postController.php" method="post" class="form-add-post" enctype="multipart/form-data">
         <?php if (isset($_SESSION['user'])) { ?>
             <input type="hidden" value="<?php echo $sessionUser->getId(); ?>" name="id_user" />
             <div class="modal-post">
                 <img src="<?php echo $sessionUser->getPicture() ?>" alt="">
                 <input type="text" name="texte" placeholder="J'adore quand..." />
             </div>
         <?php
            }
            ?>
         <input type="file" name="media">
         <div class="divide-form"></div>
         <button type="submit" class="submit-modal-post" name="newPost">poster</button>
     </form>
 </div>