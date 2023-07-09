<?php

session_start();

include('./path.php');

include(ROOT_PATH . '/main/database/db.php');

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="GCESports" />

    <title>Home Page</title>

    <!-- custom styling -->
    <link rel="stylesheet" href="./src/style/index.css?v=<?php echo time(); ?>" />
    <link rel="stylesheet" href="./src/style/header.css?v=<?php echo time(); ?>" />
    <link rel="stylesheet" href="./src/style/footer.css?v=<?php echo time(); ?>" />

    <!-- goggle fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
</head>

<body>

    <!-- header: nav-bar -->

    <?php include(ROOT_PATH . '/main/includes/header.php') ?>

    <!-- section-one: background-theme and text-animation -->
    <section class="section-one">
        <div class="content-one-a">
            <div class="content-one-bg">

            </div>

            <div class="content-one-text">
                <div class="content-one-heading-a">
                    WELCOME TO
                </div>

                <div class="content-one-heading-b">
                    GCES<span style="color: #FFCD02;">ports.</span>
                </div>

                <div class="content-one-desc">A site that keeps updating news and moments<br />
                    of sport meet events held by Gandaki College <br />
                    Of Engineering And Science(GCES) every year.</div>

                <div class="content-one-button">
                    <a href="#footer-email">CONTACT US!</a>
                </div>
            </div>

        </div>

        <!-- text-animation -->
        <div class="content-one-b">
            LATEST RESULTS:
            <span id="animated-text"></span>
        </div>
    </section>

    <?php
    $newstable = 'newspanel';
    $fixturetable = 'fixturespanel';

    $latestnews = selectDesc($newstable);
    $featurednews = selectByFeatured($newstable);
    $upcomings = selectUpcoming($fixturetable);

    function selectDesc($table)
    {
        global $conn;

        $sql = "SELECT * FROM $table ORDER BY date DESC LIMIT 2";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $records;
    }

    function selectByFeatured($table)
    {
        global $conn;

        $sql = "SELECT * FROM $table WHERE featured = '1' LIMIT 2";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $records;
    }

    function selectUpcoming($table)
    {
        global $conn;

        $sql = "SELECT * FROM $table";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $records;
    }
    ?>

    <!-- section-two: latest-news, featured-news and upcoming-events -->
    <section class="section-two">
        <div class="content-two">

            <!-- latest news -->
            <div class="content-two-b">
                <div class="content-heading">
                    LATEST NEWS
                </div>
                <?php foreach ($latestnews as $key => $latestnew) : ?>
                    <div class="content-news">
                        <div class="news-image">
                            <img src="<?php echo './media/news/' . $latestnew['image']; ?>" alt="<?php echo $latestnew['image']; ?>">
                        </div>
                        <div class="news-text">
                            <div class="news-date">
                                <div class="news-day"><?php echo date('d', strtotime($latestnew['date'])); ?></div>
                                <div class="news-month"><?php echo date('M', strtotime($latestnew['date'])); ?></div>
                                <div class="news-year"><?php echo date('Y', strtotime($latestnew['date'])); ?></div>
                            </div>
                            <div class="news-heading">
                                <a href="./page.php?page_id=<?php echo $latestnew['id']; ?>"><?php echo $latestnew['title']; ?></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- featured news -->
            <div class="content-two-a">
                <div class="content-heading">
                    FEATURED NEWS
                </div>
                <?php foreach ($featurednews as $key => $featurednew) : ?>
                    <div class="content-news">
                        <div class="news-image">
                            <img src="<?php echo './media/news/' . $featurednew['image']; ?>" alt="<?php echo $featurednew['image']; ?>">
                        </div>
                        <div class="news-text">
                            <div class="news-date">
                                <div class="news-day"><?php echo date('d', strtotime($featurednew['date'])); ?></div>
                                <div class="news-month"><?php echo date('M', strtotime($featurednew['date'])); ?></div>
                                <div class="news-year"><?php echo date('Y', strtotime($featurednew['date'])); ?></div>
                            </div>
                            <div class="news-heading">
                                <a href="./page.php?page_id=<?php echo $featurednew['id']; ?>"><?php echo $featurednew['title']; ?></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Upcoming games -->

            <div class="content-two-c">
                <div class="content-two-c-heading">
                    UPCOMING GAMES
                </div>
                <?php
                $currentDate = getdate();
                $eventCounter = 0;
                ?>
                <?php for ($i = 0; $i < count($upcomings); $i++) : ?>
                    <?php $pastdate = strtotime($upcomings[$i]['date']); ?>
                    <?php if ($currentDate[0] < ($pastdate + 86400)) : ?>
                        <?php $eventCounter++; ?>
                        <div>
                            <div class="content-two-c-title">
                                <?php echo $upcomings[$i]['firstname'] . ' (' . $upcomings[$i]['firstfaculty'] . ')'; ?>
                                <span style="opacity: 0.25;"> VS </span>
                                <?php echo $upcomings[$i]['secondname'] . ' (' . $upcomings[$i]['secondfaculty'] . ')'; ?>
                            </div>
                            <div class="content-two-c-game">
                                <?php echo "(" . $upcomings[$i]['sports'] . " MATCH)"; ?>
                            </div>
                            <div class="content-two-c-image">
                                <?php
                                $imagename = '';
                                if ($upcomings[$i]['sports'] == 'football') {
                                    $imagename = 'football.jpg';
                                } else if ($upcomings[$i]['sports'] == 'basketball') {
                                    $imagename = 'basketball.jpg';
                                } else if ($upcomings[$i]['sports'] == 'cricket') {
                                    $imagename = 'cricket.jpg';
                                } else if ($upcomings[$i]['sports'] == 'volleyball') {
                                    $imagename = 'volleyball.jpg';
                                } else {
                                    $imagename = 'loading.jpg';
                                }
                                ?>
                                <img src="./media/index/<?php echo $imagename; ?>" alt="<?php echo $imagename; ?>" />
                            </div>
                            <div class=" content-two-c-time">
                                <i class="fas fa-clock"></i>
                                <?php echo date('H', strtotime($upcomings[$i]['time'])) . ':' . date('i', strtotime($upcomings[$i]['time'])) . ' - ' . date('d', strtotime($upcomings[$i]['date'])) . ' ' . date('M', strtotime($upcomings[$i]['date'])) . ' ' . date('Y', strtotime($upcomings[$i]['date'])); ?>
                            </div>
                        </div>
                        <?php break; ?>
                    <?php endif; ?>
                <?php endfor; ?>
                <div class="content-two-c-extras">
                    <?php if ($eventCounter == 0) : ?>
                        <span>No Upcomings events</span>
                    <?php endif; ?>
                    <?php if ($eventCounter == 1) : ?>
                        <a href="./fixtures.php">SEE MORE</a>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </section>

    <?php
    $playerstable = 'players';
    $typesOf = array("football", "basketball", "cricket", "volleyball");

    function selectByPoints($table, $sports)
    {
        global $conn;

        $sql = "SELECT * FROM $table WHERE sports = '$sports' ORDER BY points DESC LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $records;
    }
    ?>

    <!-- section-three: top-players -->
    <section class="section-three">

        <div class="content-three">

            <div class="content-three-heading">
                TOP <span style="color: #FFCD02;">PLAYERS</span>
            </div>

            <div class="content-three-details">

                <?php for ($i = 0; $i < 4; $i++) : ?>
                    <?php $topplayers = selectByPoints($playerstable, $typesOf[$i]); ?>

                    <div class="player-box">
                        <div class="player-image">
                            <img src="<?php echo './media/players/' . $topplayers[0]['image']; ?>" alt="<?php echo $topplayers[0]['image']; ?>">
                        </div>
                        <div class="player-details-box">
                            <div class="player-info">
                                <div class="player-name">
                                    <?php echo $topplayers[0]['playername'] ?>
                                </div>
                                <div class="player-sports">
                                    <?php echo $topplayers[0]['sports'] ?>
                                </div>
                            </div>
                            <div class="player-score">
                                <div class="score-num"><?php echo $topplayers[0]['points'] ?></div>
                                <div class="score-unit">
                                    <?php
                                    if ($topplayers[0]['sports'] == "football") {
                                        echo "goals";
                                    } else if ($topplayers[0]['sports'] == "basketball") {
                                        echo "points";
                                    } else if ($topplayers[0]['sports'] == "cricket") {
                                        echo "runs";
                                    } else {
                                        echo "scores";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endfor; ?>

            </div>
        </div>
    </section>

    <?php
    $gallerytable = 'gallerypanel';
    $sliderRand = selectRand($gallerytable);

    function selectRand($table)
    {
        global $conn;
        $randomNum = rand(0, 10);

        if ($randomNum < 2) {
            $sql = "SELECT * FROM $table LIMIT 5";
        } elseif ($randomNum >= 2 && $randomNum < 4) {
            $sql = "SELECT * FROM $table ORDER BY name LIMIT 5";
        } elseif ($randomNum >= 4 && $randomNum < 6) {
            $sql = "SELECT * FROM $table ORDER BY image LIMIT 5";
        } elseif ($randomNum >= 6 && $randomNum < 8) {
            $sql = "SELECT * FROM $table ORDER BY date ASC LIMIT 5";
        } else {
            $sql = "SELECT * FROM $table ORDER BY date DESC LIMIT 5";
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $records;
    }
    ?>

    <!-- section-four: gallery and leaderboards -->
    <section class="section-four">
        <div class="content-four">

            <!-- gallery-section -->
            <div class="content-four-a">
                <div class="content-four-a-heading">
                    GALLERY
                </div>
                <div class="content-four-a-slider">
                    <div class="slides">
                        <input type="radio" name="radio-btn" id="radio1">
                        <input type="radio" name="radio-btn" id="radio2">
                        <input type="radio" name="radio-btn" id="radio3">
                        <input type="radio" name="radio-btn" id="radio4">
                        <input type="radio" name="radio-btn" id="radio5">

                        <div class="slide first">
                            <img src="<?php echo './media/gallery/' . $sliderRand[0]['image']; ?>" alt="<?php echo $sliderRand[0]['image']; ?>">
                        </div>
                        <div class="slide">
                            <img src="<?php echo './media/gallery/' . $sliderRand[1]['image']; ?>" alt="<?php echo $sliderRand[1]['image']; ?>">
                        </div>
                        <div class="slide">
                            <img src="<?php echo './media/gallery/' . $sliderRand[2]['image']; ?>" alt="<?php echo $sliderRand[2]['image']; ?>">
                        </div>
                        <div class="slide">
                            <img src="<?php echo './media/gallery/' . $sliderRand[3]['image']; ?>" alt="<?php echo $sliderRand[3]['image']; ?>">
                        </div>
                        <div class="slide">
                            <img src="<?php echo './media/gallery/' . $sliderRand[4]['image']; ?>" alt="<?php echo $sliderRand[4]['image']; ?>">
                        </div>
                        <div class="auto-navigation">
                            <div class="auto-btn1"></div>
                            <div class="auto-btn2"></div>
                            <div class="auto-btn3"></div>
                            <div class="auto-btn4"></div>
                            <div class="auto-btn5"></div>
                        </div>
                    </div>
                    <div class="manual-navigation">
                        <label for="radio1" class="manual-btn"></label>
                        <label for="radio2" class="manual-btn"></label>
                        <label for="radio3" class="manual-btn"></label>
                        <label for="radio4" class="manual-btn"></label>
                        <label for="radio5" class="manual-btn"></label>
                    </div>
                </div>
            </div>

            <?php
            $results = selectAll('resultspanel');
            $randType = rand(0, 3);
            ?>

            <!-- results-section -->
            <div class="content-four-b">
                <div class="content-four-b-heading">
                    RESULTS
                </div>
                <table class="results-container">
                    <thead>
                        <th>Match Details</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Learn More</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="7">
                                <?php echo $typesOf[$randType]; ?>
                            </td>
                        </tr>

                        <?php foreach ($results as $key => $result) : ?>
                            <?php if ($result['sports'] === $typesOf[$randType] && $result['firstscore'] <> '?' && $result['secondscore'] <> '?') : ?>
                                <tr>
                                    <td>
                                        <?php
                                        echo date('d', strtotime($result['date'])) . '.' . date('m', strtotime($result['date'])) . '.' . date('Y', strtotime($result['date'])) .
                                            ' - ' . date('H', strtotime($result['time'])) . ':' . date('i', strtotime($result['time']));
                                        ?>
                                    </td>
                                    <td style="text-transform: capitalize;"><?php echo $result['firstname'] . ' ' . $result['gender'] . ' (' . $result['firstfaculty'] . ')'; ?></>
                                    <td><?php echo $result['firstscore']; ?></td>
                                    <td>-</td>
                                    <td><?php echo $result['secondscore']; ?></td>
                                    <td style="text-transform: capitalize;"><?php echo $result['secondname']  . ' ' . $result['gender'] . ' (' . $result['secondfaculty'] . ')'; ?></td>
                                    <td><a href="#" class="info-link">View Info</a></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    </tbody>
                </table>

            </div>
    </section>

    <!-- footer: about-us, send-feedback and contact-us -->

    <?php include(ROOT_PATH . '/main/includes/footer.php') ?>

    <!-- font-awesome -->
    <script src="https://kit.fontawesome.com/d3be705053.js" crossorigin="anonymous"></script>

    <!-- custom scripting -->
    <script src="./src/script/index.js"></script>

</body>

</html>