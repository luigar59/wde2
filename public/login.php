<?php

require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/../src/login.php';
?>

<?php view('header', ['title' => 'Login Form']) ?>

<section id="contact" class="contact-section contact-style-3 img-bg" style="background-image: url('../../assets/img/wolf.jpg')">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-5 col-xl-5 col-lg-10 col-md-10">
                        <div class="section-title text ">
                            <br>
                            <h3 style="font-size: 64px; color: #FFA41B; white-space: nowrap;" class="mb-15">WebApp Login Form</h3>
                            <p style="font-size: 24px; color: #FFA41B; white-space: nowrap;">Please fill the following form to login into your account.</p>
                        </div>
                    </div>
                </div>
                
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                       
                    </div>
                    <div class="col-lg-4">
                        <div class="contact-form-wrapper" style="padding: 20px; border-radius: 10px; border: 4px solid #FFA41B; background-color: rgba(235, 194, 110, 0.5);">
                            <form action="login.php" method="post">
                                <div class="row">                                    
                                    <div class="col-md-12">
                                        <label for="username">Username:</label>
                                        <div class="single-input">
                                            <input type="text" name="username" id="username" value="<?= $inputs['username'] ?? '' ?>" 
                                                class="form-input" placeholder="Enter Your Username Here.">
                                            <i class="bx bx-user"></i>
                                                <br>
                                                <small style="color:red;" class="<?= error_class($errors, 'username') ?>"><?= $errors['username'] ?? '' ?></small>                                            
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="password">Password:</label>
                                        <div class="single-input">
                                            <input type="password" name="password" id="password" value="<?= $inputs['password'] ?? '' ?>"
                                                class="form-input" placeholder="Enter Your Password Here.">
                                            <i class="bx bx-lock"></i>
                                                <br>
                                                <small style="color:red;" class="<?= error_class($errors, 'password') ?>"><?= $errors['password'] ?? '' ?></small>                                            
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label>&nbsp;</label>
                                        <div class="form-button">
                                            <button type="submit" class="button"><i class="bx bx-enter"></i>Login</button>
                                            <br>
                                            <div class="section-title text-center mb-50">
                                                <img src="./img/login.png" width="60%" alt="Register" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <footer>Are you not a member? <a href="register.php">Register here</a></footer>
                                <footer >Forgot Password? <a href="forgot.php"> Check here</a></footer> 
                            </form>
                        </div>    
                    </div>
                    <div class="col-lg-4">

                    </div>
                </div>
            </div>
        </section>

<?php view('footer') ?>