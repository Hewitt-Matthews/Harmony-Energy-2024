<?php

$contactDetails = get_field('contact_details', 'option');
$email = $contactDetails['main_contact_email'];

if ($email) : ?>

<a href="mailto:<?= $email ?>"><?= $email ?></a>

<?php endif; ?>