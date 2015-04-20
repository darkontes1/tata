<?php

$id = filter_input(INPUT_POST, 'singleimage', FILTER_VALIDATE_INT);

//$id = 45;

$objImage = new classImage();
$image = $objImage->getImage($id);

//var_dump($image);

if(!is_null($image)) {
?>

<figure class="">
    <div class="blocimg"><img src="<?php echo $objImage->getRealPath();?>" 
                              alt="<?php echo $objImage->getNom();?>">
            </div>
    <figcaption><?php echo $objImage->getCaption() ;?></figcaption>
</figure>

<?php } else {
    echo 'Rien à afficher';
} 



?>