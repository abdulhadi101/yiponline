<?php
/* Smarty version 5.8.0, created on 2026-05-25 09:48:15
  from 'file:layouts/main.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_6a141adfc79191_54655763',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '226f504aa5ad0c3524c0f357746a0435446537db' => 
    array (
      0 => 'layouts/main.tpl',
      1 => 1779701880,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6a141adfc79191_54655763 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/home/abdulhadi/development/yip-ecommerce/resources/smarty/templates/layouts';
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo (($tmp = $_smarty_tpl->getValue('pageTitle') ?? null)===null||$tmp==='' ? 'Smarty Demo' ?? null : $tmp);?>
 - YipOnline</title>
    <style>
        :root {
            --bg: #f8fafc;
            --surface: #ffffff;
            --text: #0f172a;
            --muted: #475569;
            --brand: #1d4ed8;
            --border: #e2e8f0;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: "Instrument Sans", "Segoe UI", sans-serif;
            background: linear-gradient(180deg, #eff6ff 0%, var(--bg) 40%);
            color: var(--text);
        }
        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 1.25rem;
        }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .topbar a {
            color: var(--brand);
            text-decoration: none;
            font-weight: 600;
        }
        .panel {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1rem;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.06);
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        .card {
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
        }
        .card img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            background: #f1f5f9;
        }
        .card-content {
            padding: 0.85rem;
        }
        .card h3 {
            margin: 0 0 0.35rem;
            font-size: 1rem;
        }
        .meta { color: var(--muted); font-size: 0.875rem; }
        .price { color: var(--brand); font-weight: 700; margin-top: 0.5rem; }
        .search {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        .search input {
            flex: 1;
            min-width: 220px;
            padding: 0.6rem 0.7rem;
            border: 1px solid var(--border);
            border-radius: 8px;
        }
        .search button {
            padding: 0.6rem 0.9rem;
            border: 0;
            border-radius: 8px;
            background: var(--brand);
            color: #fff;
            cursor: pointer;
        }
        .empty {
            text-align: center;
            color: var(--muted);
            padding: 2rem 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php echo $_smarty_tpl->getValue('content');?>

    </div>
</body>
</html>
<?php }
}
