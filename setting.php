<?php
include_once("./db.config/db_conn.php");
session_start();
$user = $_SESSION['logged_in'];
if (!isset($user)) {
    header("location:login.php");
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./css/home.css">

    <title>Document</title>
</head>

<body>
    <nav style="position: fixed;z-index: 1">
        <ul>
            <li class="pb-5 mb-5">
                <a href="./profile.php">
                    <img src="./images/<?php echo $_SESSION['image'];
                                        ?>" alt="">
                    <span class="nav-item"><?php
                                            echo      $_SESSION['name'] ?></span>
                </a>
            </li>
            <li><a href="./profile.php">
                    <i class="bi bi-person-circle"></i>
                    <span class="nav-item">Profile</span>
                </a>
            </li>
            <li><a href="./home.php">
                    <i class="bi bi-house-door"></i>
                    <span class="nav-item">Home</span>
                </a></li>
            <li><a href="./explore.php">
                    <i class="bi bi-hash"></i>

                    <span class="nav-item">Explore</span>
                </a></li>
            <li><a href="#">
                    <i class="bi bi-chat-left-dots"></i>

                    <span class="nav-item">Messages</span>
                </a>
            </li>
            <li><a href="./notifcation.php">
                    <i class="bi bi-bell-fill"></i>
                    <span class="nav-item">Notifications</span>
                </a>
            </li>
            <li><a href="./add_post.php">
                    <i class="bi bi-file-post"></i>

                    <span class="nav-item">Add post</span>
                </a>
            </li>
            <li><a href="./setting.php">
                    <i class="bi bi-gear"></i>

                    <span class="nav-item">Setting</span>
                </a>
            </li>
            <li><a href="./favorite.php">
                    <i class="bi bi-star-fill"></i>

                    <span class="nav-item">Favorites</span>
                </a>
            </li>
            <li><a href="logout.php" class="logout">
                    <i class="bi bi-door-open-fill"></i>
                    <span class="nav-item">Log out</span>
                </a></li>
            <button id="modeButton" class="mode " onclick="ChangeMode()"></button>

        </ul>
    </nav>
    <div class="setting mt-3 pb-1">
        <div class="setting-header">
            <div class="setting-nav">
                <a href="profile.php" class="setting-nav-back"><i class="bi bi-arrow-left"></i></a>
                <h1 class="pt-5">Settings</h1>
                <div class="d-flex" style="flex-direction: column; gap:10px;">
                    <a href="setting.php">Edit profile</a>
                    <a href="Change-password.php">Change password</a>
                    <form action="./db.config/setting.inc.php" method="post" onsubmit="return confirm('Are you sure you want to deactivate your account?')">
                        <input type="submit" name="deactivate" value="Deactivate Account" style="background-color: transparent; color:#007bff">
                    </form>
                </div>

            </div>
            <form action="./db.config/setting.inc.php" method="post" enctype="multipart/form-data">
                <div class="edit-profile">
                    <div class="user">
                        <img src="./images/<?php echo $_SESSION['image'] ?>" alt="">
                        <div>
                            <p class="mb-0 mt-4"><?php echo $_SESSION['name'] ?></p>
                        </div>
                    </div>
                    <p class="mb-0 mt-4" style="opacity: 0.7; color:rgb(83,83,83)"><?php echo $_SESSION['date']; ?></p>
                    <input type="file" name="image" id="input-file" style="display: none;" accept="image/*">
                    <label class="inputbox pt-3" for="input-file" style="border: 1px solid transparent;color:#007bff; cursor:pointer">Change Image</label>
                    <p style="width:420px; font-size:13px;text-align:justify; color:rgb(85, 83, 83);" class="image-error"><span style="opacity: 0.8;">To ensure that your image can be properly processed, we request that you upload it in one of the following formats:</span><span style="color: red;opacity:0.9 !important;"> JPG, PNG, or JPEG.</span><span style="opacity: 0.8;"> Additionally, we kindly ask that you keep </span><span style="color: red;opacity:0.9 !important;">the file size under 10MB.</span><span style="opacity: 0.8;"> Thank you for your cooperation.</span></p>
                    <div class="name-change pt-3" style="gap: 5px;">
                        <label for="name">Name </label>
                        <?php
                        if (isset($_POST["submit"])) {

                            $name = $_POST['name'];

                            if (strlen($name) > 15 || strlen($name) < 4) {
                                echo ("<div>name must be between 4 to 15 character</div>");
                            } elseif (!preg_match('/^[a-zA-Z0-9_\-]+$/', $name)) {
                            }
                        }
                        ?>
                        <input type="text" name="name" value="<?php echo $_SESSION['name'] ?>">
                        <p class="name-error pt-2" style="font-size: 13px; width:420px;text-align:justify;word-wrap: break-word;
                        "><span style="opacity: 0.5;">Create a name with a</span> <span style="color: red;opacity:0.9 !important;">character count between 4 and 15</span><span style="opacity: 0.5;">, which excludes</span><span style="color: red;opacity:0.9 !important;"> spaces, letters, numbers, dashes, and underscores.</span></p>
                    </div>
                    <div class="name-change pt-3">
                        <div style="gap: 5px; flex-direction:column;" class="descrpt d-flex">
                            <label for="description">Description </label>
                            <textarea name="description" style="border: 1px solid #6C63FF;color:rgb(83,83,83);padding-left:4px; border-radius:5px;opacity:0.7;" placeholder="description..." maxlength="150"><?php echo $_SESSION['desc'] ?></textarea>
                            <p class="pt-2" style="font-size: 13px; width:420px;text-align:justify;"><span style="opacity: 0.5;">Please kindly ensure that your description adheres to a</span><span style="color: red;opacity:0.9 !important;"> character limit of 0 to 150</span><span style="opacity: 0.5;">, and kindly note that only</span><span style="color: red;opacity:0.9 !important;"> symbols are not permitted.</span><span style="opacity: 0.5;"> Thank you for clarifying.</span></p>

                        </div>
                    </div>
                    <div class="name-change">
                        <p class="pt-5">Personal information</p>
                        <p style="font-size: 13px; width:420px; opacity:0.4" class="name-error">
                            Provide your personal information, even if the account is used for a business, a pet or something else. This won't be a part of your public profile.</p>
                    </div>
                    <div class="name-change pt-4 d-flex align-center">
                        <label for="name" style="padding-right: 85px;">Email </label>
                        <input type="text" value="<?php echo $_SESSION['email'] ?>" readonly>
                    </div>
                    <div class="name-change pt-4 d-flex align-center">
                        <label for="name" style="padding-right: 10px;">phone number </label>
                        <input type="number" name="phone" value="<?php echo $_SESSION['phone'] ?>">
                    </div>
                    <div class="name-change pt-4 d-flex align-center">
                        <label for="name" style="padding-right: 65px;">Country </label>
                        <select class="form-select" id="country" name="country">
                            <option><?php echo $_SESSION['country'] ?></option>
                            <option value="Afghanistan">Afghanistan</option>
                            <option value="Åland Islands">Åland Islands</option>
                            <option value="Albania">Albania</option>
                            <option value="Algeria">Algeria</option>
                            <option value="American Samoa">American Samoa</option>
                            <option value="Andorra">Andorra</option>
                            <option value="Angola">Angola</option>
                            <option value="Anguilla">Anguilla</option>
                            <option value="Antarctica">Antarctica</option>
                            <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                            <option value="Argentina">Argentina</option>
                            <option value="Armenia">Armenia</option>
                            <option value="Aruba">Aruba</option>
                            <option value="Australia">Australia</option>
                            <option value="Austria">Austria</option>
                            <option value="Azerbaijan">Azerbaijan</option>
                            <option value="Bahamas">Bahamas</option>
                            <option value="Bahrain">Bahrain</option>
                            <option value="Bangladesh">Bangladesh</option>
                            <option value="Barbados">Barbados</option>
                            <option value="Belarus">Belarus</option>
                            <option value="Belgium">Belgium</option>
                            <option value="Belize">Belize</option>
                            <option value="Benin">Benin</option>
                            <option value="Bermuda">Bermuda</option>
                            <option value="Bhutan">Bhutan</option>
                            <option value="Bolivia">Bolivia</option>
                            <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                            <option value="Botswana">Botswana</option>
                            <option value="Bouvet Island">Bouvet Island</option>
                            <option value="Brazil">Brazil</option>
                            <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                            <option value="Brunei Darussalam">Brunei Darussalam</option>
                            <option value="Bulgaria">Bulgaria</option>
                            <option value="Burkina Faso">Burkina Faso</option>
                            <option value="Burundi">Burundi</option>
                            <option value="Cambodia">Cambodia</option>
                            <option value="Cameroon">Cameroon</option>
                            <option value="Canada">Canada</option>
                            <option value="Cape Verde">Cape Verde</option>
                            <option value="Cayman Islands">Cayman Islands</option>
                            <option value="Central African Republic">Central African Republic</option>
                            <option value="Chad">Chad</option>
                            <option value="Chile">Chile</option>
                            <option value="China">China</option>
                            <option value="Christmas Island">Christmas Island</option>
                            <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                            <option value="Colombia">Colombia</option>
                            <option value="Comoros">Comoros</option>
                            <option value="Congo">Congo</option>
                            <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                            <option value="Cook Islands">Cook Islands</option>
                            <option value="Costa Rica">Costa Rica</option>
                            <option value="Cote D'ivoire">Cote D'ivoire</option>
                            <option value="Croatia">Croatia</option>
                            <option value="Cuba">Cuba</option>
                            <option value="Cyprus">Cyprus</option>
                            <option value="Czech Republic">Czech Republic</option>
                            <option value="Denmark">Denmark</option>
                            <option value="Djibouti">Djibouti</option>
                            <option value="Dominica">Dominica</option>
                            <option value="Dominican Republic">Dominican Republic</option>
                            <option value="Ecuador">Ecuador</option>
                            <option value="Egypt">Egypt</option>
                            <option value="El Salvador">El Salvador</option>
                            <option value="Equatorial Guinea">Equatorial Guinea</option>
                            <option value="Eritrea">Eritrea</option>
                            <option value="Estonia">Estonia</option>
                            <option value="Ethiopia">Ethiopia</option>
                            <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                            <option value="Faroe Islands">Faroe Islands</option>
                            <option value="Fiji">Fiji</option>
                            <option value="Finland">Finland</option>
                            <option value="France">France</option>
                            <option value="French Guiana">French Guiana</option>
                            <option value="French Polynesia">French Polynesia</option>
                            <option value="French Southern Territories">French Southern Territories</option>
                            <option value="Gabon">Gabon</option>
                            <option value="Gambia">Gambia</option>
                            <option value="Georgia">Georgia</option>
                            <option value="Germany">Germany</option>
                            <option value="Ghana">Ghana</option>
                            <option value="Gibraltar">Gibraltar</option>
                            <option value="Greece">Greece</option>
                            <option value="Greenland">Greenland</option>
                            <option value="Grenada">Grenada</option>
                            <option value="Guadeloupe">Guadeloupe</option>
                            <option value="Guam">Guam</option>
                            <option value="Guatemala">Guatemala</option>
                            <option value="Guernsey">Guernsey</option>
                            <option value="Guinea">Guinea</option>
                            <option value="Guinea-bissau">Guinea-bissau</option>
                            <option value="Guyana">Guyana</option>
                            <option value="Haiti">Haiti</option>
                            <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                            <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                            <option value="Honduras">Honduras</option>
                            <option value="Hong Kong">Hong Kong</option>
                            <option value="Hungary">Hungary</option>
                            <option value="Iceland">Iceland</option>
                            <option value="India">India</option>
                            <option value="Indonesia">Indonesia</option>
                            <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                            <option value="Iraq">Iraq</option>
                            <option value="Ireland">Ireland</option>
                            <option value="Isle of Man">Isle of Man</option>
                            <option value="Israel">Israel</option>
                            <option value="Italy">Italy</option>
                            <option value="Jamaica">Jamaica</option>
                            <option value="Japan">Japan</option>
                            <option value="Jersey">Jersey</option>
                            <option value="Jordan">Jordan</option>
                            <option value="Kazakhstan">Kazakhstan</option>
                            <option value="Kenya">Kenya</option>
                            <option value="Kiribati">Kiribati</option>
                            <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                            <option value="Korea, Republic of">Korea, Republic of</option>
                            <option value="Kuwait">Kuwait</option>
                            <option value="Kyrgyzstan">Kyrgyzstan</option>
                            <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                            <option value="Latvia">Latvia</option>
                            <option value="Lebanon">Lebanon</option>
                            <option value="Lesotho">Lesotho</option>
                            <option value="Liberia">Liberia</option>
                            <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                            <option value="Liechtenstein">Liechtenstein</option>
                            <option value="Lithuania">Lithuania</option>
                            <option value="Luxembourg">Luxembourg</option>
                            <option value="Macao">Macao</option>
                            <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                            <option value="Madagascar">Madagascar</option>
                            <option value="Malawi">Malawi</option>
                            <option value="Malaysia">Malaysia</option>
                            <option value="Maldives">Maldives</option>
                            <option value="Mali">Mali</option>
                            <option value="Malta">Malta</option>
                            <option value="Marshall Islands">Marshall Islands</option>
                            <option value="Martinique">Martinique</option>
                            <option value="Mauritania">Mauritania</option>
                            <option value="Mauritius">Mauritius</option>
                            <option value="Mayotte">Mayotte</option>
                            <option value="Mexico">Mexico</option>
                            <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                            <option value="Moldova, Republic of">Moldova, Republic of</option>
                            <option value="Monaco">Monaco</option>
                            <option value="Mongolia">Mongolia</option>
                            <option value="Montenegro">Montenegro</option>
                            <option value="Montserrat">Montserrat</option>
                            <option value="Morocco">Morocco</option>
                            <option value="Mozambique">Mozambique</option>
                            <option value="Myanmar">Myanmar</option>
                            <option value="Namibia">Namibia</option>
                            <option value="Nauru">Nauru</option>
                            <option value="Nepal">Nepal</option>
                            <option value="Netherlands">Netherlands</option>
                            <option value="Netherlands Antilles">Netherlands Antilles</option>
                            <option value="New Caledonia">New Caledonia</option>
                            <option value="New Zealand">New Zealand</option>
                            <option value="Nicaragua">Nicaragua</option>
                            <option value="Niger">Niger</option>
                            <option value="Nigeria">Nigeria</option>
                            <option value="Niue">Niue</option>
                            <option value="Norfolk Island">Norfolk Island</option>
                            <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                            <option value="Norway">Norway</option>
                            <option value="Oman">Oman</option>
                            <option value="Pakistan">Pakistan</option>
                            <option value="Palau">Palau</option>
                            <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                            <option value="Panama">Panama</option>
                            <option value="Papua New Guinea">Papua New Guinea</option>
                            <option value="Paraguay">Paraguay</option>
                            <option value="Peru">Peru</option>
                            <option value="Philippines">Philippines</option>
                            <option value="Pitcairn">Pitcairn</option>
                            <option value="Poland">Poland</option>
                            <option value="Portugal">Portugal</option>
                            <option value="Puerto Rico">Puerto Rico</option>
                            <option value="Qatar">Qatar</option>
                            <option value="Reunion">Reunion</option>
                            <option value="Romania">Romania</option>
                            <option value="Russian Federation">Russian Federation</option>
                            <option value="Rwanda">Rwanda</option>
                            <option value="Saint Helena">Saint Helena</option>
                            <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                            <option value="Saint Lucia">Saint Lucia</option>
                            <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                            <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                            <option value="Samoa">Samoa</option>
                            <option value="San Marino">San Marino</option>
                            <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                            <option value="Saudi Arabia">Saudi Arabia</option>
                            <option value="Senegal">Senegal</option>
                            <option value="Serbia">Serbia</option>
                            <option value="Seychelles">Seychelles</option>
                            <option value="Sierra Leone">Sierra Leone</option>
                            <option value="Singapore">Singapore</option>
                            <option value="Slovakia">Slovakia</option>
                            <option value="Slovenia">Slovenia</option>
                            <option value="Solomon Islands">Solomon Islands</option>
                            <option value="Somalia">Somalia</option>
                            <option value="South Africa">South Africa</option>
                            <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                            <option value="Spain">Spain</option>
                            <option value="Sri Lanka">Sri Lanka</option>
                            <option value="Sudan">Sudan</option>
                            <option value="Suriname">Suriname</option>
                            <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                            <option value="Swaziland">Swaziland</option>
                            <option value="Sweden">Sweden</option>
                            <option value="Switzerland">Switzerland</option>
                            <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                            <option value="Taiwan">Taiwan</option>
                            <option value="Tajikistan">Tajikistan</option>
                            <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                            <option value="Thailand">Thailand</option>
                            <option value="Timor-leste">Timor-leste</option>
                            <option value="Togo">Togo</option>
                            <option value="Tokelau">Tokelau</option>
                            <option value="Tonga">Tonga</option>
                            <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                            <option value="Tunisia">Tunisia</option>
                            <option value="Turkey">Turkey</option>
                            <option value="Turkmenistan">Turkmenistan</option>
                            <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                            <option value="Tuvalu">Tuvalu</option>
                            <option value="Uganda">Uganda</option>
                            <option value="Ukraine">Ukraine</option>
                            <option value="United Arab Emirates">United Arab Emirates</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="United States">United States</option>
                            <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                            <option value="Uruguay">Uruguay</option>
                            <option value="Uzbekistan">Uzbekistan</option>
                            <option value="Vanuatu">Vanuatu</option>
                            <option value="Venezuela">Venezuela</option>
                            <option value="Viet Nam">Viet Nam</option>
                            <option value="Virgin Islands, British">Virgin Islands, British</option>
                            <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                            <option value="Wallis and Futuna">Wallis and Futuna</option>
                            <option value="Western Sahara">Western Sahara</option>
                            <option value="Yemen">Yemen</option>
                            <option value="Zambia">Zambia</option>
                            <option value="Zimbabwe">Zimbabwe</option>
                        </select>
                    </div>
                    <button class="mt-5" name="submit">Submit</button>
                    <div style="flex-direction: column;" class="d-flex pt-4">
                        <a href="logout.php" class="mx-3">Log out</a>
                    </div>
                </div>
            </form>
        </div>
        <script src="./js/script.js"></script>
        </nav>