<?php
var_dump($this->params->get('templateColor'));
echo "</pre>";
$this->meta = '';
if ($this->description) {
    $this->meta .= '' .
        '<meta name="description" content="' . $this->description . '">';
}
if ($this->_metaTags['name']['keywords']) {
    $this->meta .= '' .
        '<meta name="keywords" content="' . $this->_metaTags['name']['keywords'] . '">';
}
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <title><?php echo $this->title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <?php echo $this->meta ?>
    <link rel="stylesheet" href="/templates/protostar/css/uikit.css">
</head>
<body>

</body>
</html>
