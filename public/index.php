<?php

require __DIR__ . '/../src/bootstrap.php';
require_login();
?>

<?php view('header', ['title' => 'Dashboard']) ?>

<section id="contact" class="contact-section contact-style-3 img-bg" style="background-image: url('../../assets/img/wolf.jpg')">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-5 col-xl-5 col-lg-7 col-md-10">
                        <div class="section-title text-center mb-50">
                            <br>
                            <h3 style="font-size: 64px; color: #FFA41B; white-space: nowrap;" class="mb-15">WebApp Dashboard</h3>
                            <p></p>
                        </div>
                    </div>
                </div>
                
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <div class="section-title text-center mb-50">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="contact-form-wrapper" style="padding: 20px; border-radius: 10px; border: 4px solid #FFA41B; background-color: rgba(235, 194, 110, 0.5);">
                            <p>Welcome <?= current_user() ?> <a href="logout.php">Logout</a></p>
                            <div class="section-title text-center mb-50">
                                <img src="./img/good.png" width="60%" alt="Register" />
                                <footer >Forgot Password? <a href="change.php"> Check here</a></footer>
                            </div> 
                        </div>   
                    </div>
                    <div class="col-lg-4">
                        
                    </div>
                </div>
            </div>
        </section>
<?php view('footer') ?>