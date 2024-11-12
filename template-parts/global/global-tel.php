<?php

$contactDetails = get_field('contact_details', 'option');
$tel = $contactDetails['main_contact_number'];

if ($tel) : ?>

<a href="tel:<?= $tel ?>"><?= $tel ?></a>

<?php endif; ?>