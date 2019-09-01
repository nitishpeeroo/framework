<?= $renderer->render('header') ?>
<h1>Bienvenue sur le blog</h1>

<ul>
    <li><a href="<?=  $router->generateUri('blog.show', ['slug' => 'azeaze0-7-decdfv']); ?>">Article  test</a></li>
    <li>Article 1</li>
    <li>Article 1</li>
    <li>Article 1</li>
    <li>Article 1</li>
</ul>
<?= $renderer->render('footer') ?>
