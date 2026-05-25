<?php
/* Smarty version 5.8.0, created on 2026-05-25 09:48:15
  from 'file:products/index.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a141adfc6f573_34339392',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '78d0e7afc6e50bbb09e56050a99c12b18e59ee14' => 
    array (
      0 => 'products/index.tpl',
      1 => 1779701893,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layouts/main.tpl' => 1,
  ),
))) {
function content_6a141adfc6f573_34339392 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/home/abdulhadi/development/yip-ecommerce/resources/smarty/templates/products';
$_smarty_tpl->getSmarty()->getRuntime('Capture')->open($_smarty_tpl, 'default', 'content', null);?>
<div class="topbar">
    <div>
        <h1 style="margin:0;">Smarty Product Listing</h1>
        <p class="meta" style="margin:0.35rem 0 0;">Bonus implementation: server-rendered template with Smarty</p>
    </div>
    <a href="/">Back to Vue Storefront</a>
</div>

<div class="panel">
    <form method="get" action="/smarty/products" class="search">
        <input type="text" name="search" value="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('search'), ENT_QUOTES, 'UTF-8', true);?>
" placeholder="Search products by name or description" />
        <button type="submit">Search</button>
    </form>
    <p class="meta" style="margin:0.75rem 0 0;">Found <?php echo $_smarty_tpl->getValue('totalProducts');?>
 product(s)</p>

    <?php if ($_smarty_tpl->getValue('totalProducts') > 0) {?>
        <div class="grid">
            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('products'), 'product');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('product')->value) {
$foreach0DoElse = false;
?>
                <article class="card">
                    <img src="<?php echo (($tmp = $_smarty_tpl->getValue('product')['image'] ?? null)===null||$tmp==='' ? '/images/placeholder.svg' ?? null : $tmp);?>
" alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('product')['name'], ENT_QUOTES, 'UTF-8', true);?>
" loading="lazy" />
                    <div class="card-content">
                        <h3><?php echo htmlspecialchars((string)$_smarty_tpl->getValue('product')['name'], ENT_QUOTES, 'UTF-8', true);?>
</h3>
                        <p class="meta"><?php echo htmlspecialchars((string)$_smarty_tpl->getSmarty()->getModifierCallback('truncate')($_smarty_tpl->getValue('product')['description'],92), ENT_QUOTES, 'UTF-8', true);?>
</p>
                        <div class="price">$<?php echo sprintf('%.2f',$_smarty_tpl->getValue('product')['price']);?>
</div>
                        <p class="meta">Stock: <?php echo $_smarty_tpl->getValue('product')['stock'];?>
</p>
                    </div>
                </article>
            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
        </div>
    <?php } else { ?>
        <div class="empty">No products match your search.</div>
    <?php }?>
</div>
<?php $_smarty_tpl->getSmarty()->getRuntime('Capture')->close($_smarty_tpl);?>

<?php $_smarty_tpl->renderSubTemplate('file:layouts/main.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('pageTitle'=>$_smarty_tpl->getValue('pageTitle'),'content'=>$_smarty_tpl->getValue('content')), (int) 0, $_smarty_current_dir);
}
}
