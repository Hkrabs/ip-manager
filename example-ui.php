<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IP Blacklist</title>
</head>
<body>
    <div class="blacklist-form">
        <form action="add-to-blacklist.php?redirect=<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
            <h3>Karalisteye ekle</h3>
            <div>
                <div>
                    IP Adresi:
                </div>
                <div>
                    <input type="text" name="ip_address" />
                </div>
            </div>
            <div>
                <div>
                    Son Dakikaları:
                </div>
                <div>
                    <input type="number" name="ttl" />
                </div>
            </div>
            <div>
                <div>
                    Sebep:
                </div>
                <div>
                    <input type="text" name="reason" />
                </div>
            </div>
            <div>
                <button type="submit">Kaydet</button>
            </div>
        </form>
    </div>
    <div class="whitelist-form">
        <form action="add-to-whitelist.php?redirect=<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
            <h3>Beyazlisteye ekle</h3>
            <div>
                <div>
                    IP Adresi:
                </div>
                <div>
                    <input type="text" name="ip_address" />
                </div>
            </div>
            <div>
                <button type="submit">Kaydet</button>
            </div>
        </form>
    </div>
    <div>
        <p>
            <a href="blacklist.php">Karaliste</a>
        </p>
    </div>
</body>
</html>