  <style>
      .hidden {
          display: none;
      }

      .modal {
          position: absolute;
          top: 5%;
          width: 100%;
          background-color: white;
          border-radius: 5px;
          box-shadow: 0 3rem 5rem rgba(0, 0, 0, 0.3);
          z-index: 10;
      }

      .close-modal {
          font-size: 35px;
          color: #333;
          cursor: pointer;
          border: none;
          background: none;
      }

      .modal-post {
          display: flex;
          padding: 10px 0px;
          align-items: center;
      }

      .modal-post img {
          width: 50px;
          height: 50px;
          border-radius: 50%;
          margin: 0px 10px 0px 0px;
          object-fit: cover;
      }

      .modal-post input {
          width: -webkit-fill-available;
          border: none;
          outline: none;
      }

      .submit-modal-post {
          display: block;
          margin-left: auto;
          margin-right: 10px;
          text-align: center;
          padding: 10px 25px;
          background-color: #E6CCB2;
          color: white;
          border: none;
          border-radius: 50px;
          text-decoration: none;
          font-size: 15px;
      }

      .submit-modal-post:hover {
          background-color: #7F5539
      }

      .overlay {
          position: absolute;
          top: 0;
          left: 0;
          width: -webkit-fill-available;
          ;
          height: 100%;
          background-color: rgba(0, 0, 0, 0.6);
          backdrop-filter: blur(3px);
          z-index: 5;
      }
  </style>

  <div class="modal hidden">
      <button class="close-modal">&times;</button>
      <form action="/ressources/controller/postController.php" method="post" class="form-add-post">
          <?php if (isset($_SESSION['user'])) { ?>
              <input type="hidden" value="<?php echo $sessionUser->getId(); ?>" name="id_user" />


              <div class="modal-post">
                  <img src="<?php echo $sessionUser->getPicture() ?>" alt="">
                  <input type="text" name="texte" placeholder="J'adore quand..." />
              </div>
          <?php
            }
            ?>
          <input type="file" name="media" />
          <div class="divide-form"></div>
          <button type="submit" class="submit-modal-post" name="newPost">poster</button>
      </form>
  </div>