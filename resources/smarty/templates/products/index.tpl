{capture assign=content}
<div class="topbar">
    <div>
        <h1 style="margin:0;">Smarty Product Listing</h1>
        <p class="meta" style="margin:0.35rem 0 0;">Bonus implementation: server-rendered template with Smarty</p>
    </div>
    <a href="/">Back to Vue Storefront</a>
</div>

<div class="panel">
    <form method="get" action="/smarty/products" class="search">
        <input type="text" name="search" value="{$search|escape}" placeholder="Search products by name or description" />
        <button type="submit">Search</button>
    </form>
    <p class="meta" style="margin:0.75rem 0 0;">Found {$totalProducts} product(s)</p>

    {if $totalProducts > 0}
        <div class="grid">
            {foreach $products as $product}
                <article class="card">
                    <img src="{$product.image|default:'/images/placeholder.svg'}" alt="{$product.name|escape}" loading="lazy" />
                    <div class="card-content">
                        <h3>{$product.name|escape}</h3>
                        <p class="meta">{$product.description|truncate:92|escape}</p>
                        <div class="price">₦{$product.price|string_format:'%.2f'}</div>
                        <p class="meta">Stock: {$product.stock}</p>
                    </div>
                </article>
            {/foreach}
        </div>
    {else}
        <div class="empty">No products match your search.</div>
    {/if}
</div>
{/capture}

{include file='layouts/main.tpl' pageTitle=$pageTitle content=$content}
