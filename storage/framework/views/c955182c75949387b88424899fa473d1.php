

<?php $__env->startSection('title', $product->name . ' - ' . config('app.name')); ?>

<?php $__env->startSection('meta'); ?>
    <meta name="description" content="<?php echo e($product->marketing_description ?? $product->description); ?>">
    <meta property="og:type" content="product">
    <meta property="og:url" content="<?php echo e(url()->current()); ?>">
    <meta property="og:title" content="<?php echo e($product->name); ?>">
    <meta property="og:description" content="<?php echo e($product->marketing_description ?? $product->description); ?>">
    <meta property="og:image" content="<?php echo e($product->image ? (Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image)) : asset('logo.svg')); ?>">
    <meta property="product:price:amount" content="<?php echo e($product->price); ?>">
    <meta property="product:price:currency" content="BRL">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="product-card">
        
        <div class="row">

            <!-- Coluna de Imagens (Esquerda) -->
            <div class="col-lg-6 mb-4 mb-lg-0">
                <!-- Imagem Principal -->
                <div class="mb-3">
                    <img id="mainProductImage" 
                         src="<?php echo e($product->image ? (Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image)) : 'https://placehold.co/800x800/f0f8ff/1a1a1a?text='.urlencode($product->name)); ?>" 
                         class="main-image shadow-sm w-100 rounded" 
                         alt="<?php echo e($product->name); ?>"
                         style="object-fit: cover; aspect-ratio: 1; cursor: zoom-in;"
                         onerror="this.onerror=null;this.src='https://placehold.co/800x800/f0f8ff/1a1a1a?text=Imagem+Indispon%C3%ADvel';">
                </div>

                <!-- Galeria de Miniaturas -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->images->count() > 0): ?>
                    <div class="row row-cols-4 g-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col">
                                <img src="<?php echo e(asset('storage/' . $image->path)); ?>" 
                                     class="img-fluid thumbnail-image rounded <?php echo e($image->is_main ? 'active border border-2 border-primary' : 'border border-secondary opacity-75'); ?>" 
                                     alt="Imagem <?php echo e($loop->iteration); ?>"
                                     style="cursor: pointer; aspect-ratio: 1; object-fit: cover; transition: all 0.3s;"
                                     onclick="changeMainImage(this.src)"
                                     onmouseover="this.style.opacity='1'; this.classList.add('shadow')"
                                     onmouseout="this.style.opacity='<?php echo e($image->is_main ? '1' : '0.75'); ?>'; this.classList.remove('shadow')"
                                     onerror="this.src='https://placehold.co/200x200/f8f9fa/adb5bd?text=<?php echo e($loop->iteration); ?>'">
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php else: ?>
                    <!-- Fallback: Se não houver galeria, mostra apenas a imagem principal como thumbnail -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->image): ?>
                        <div class="row row-cols-4 g-2">
                            <div class="col">
                                <img src="<?php echo e(Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image)); ?>" 
                                     class="img-fluid thumbnail-image active rounded border border-2 border-primary" 
                                     alt="Principal"
                                     style="aspect-ratio: 1; object-fit: cover; opacity: 1;">
                            </div>
                            <!-- Placeholders -->
                            <div class="col">
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="aspect-ratio: 1;">
                                    <i class="bi bi-camera text-muted fs-3"></i>
                                </div>
                            </div>
                            <div class="col">
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="aspect-ratio: 1;">
                                    <i class="bi bi-camera text-muted fs-3"></i>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Coluna de Detalhes e Ações (Direita) -->
            <div class="col-lg-6">
                
                <!-- Breadcrumb (Migalhas de Pão) -->
                <nav aria-label="breadcrumb" class="mb-2">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('shop.index')); ?>" class="text-decoration-none">Início</a></li>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->category): ?>
                            <li class="breadcrumb-item">
                                <a href="<?php echo e(route('shop.category', $product->category->slug)); ?>" class="text-decoration-none">
                                    <?php echo e($product->category->name); ?>

                                </a>
                            </li>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo e($product->name); ?></li>
                    </ol>
                </nav>

                <!-- Título e Avaliação -->
                <h1 class="h3 fw-bold mb-1"><?php echo e($product->name); ?></h1>
                <div class="text-warning mb-3">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                    <span class="ms-2 text-muted small">(128 Avaliações)</span>
                </div>

                <!-- Preço -->
                <div class="mb-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->is_offer && $product->old_price): ?>
                        <p class="price-display text-success h2 fw-bold mb-0">R$ <?php echo e(number_format($product->price, 2, ',', '.')); ?></p>
                        <p class="text-muted">
                            <s class="me-2">De R$ <?php echo e(number_format($product->old_price, 2, ',', '.')); ?></s> 
                            <span class="badge bg-success-subtle text-success">
                                <?php echo e(round((($product->old_price - $product->price) / $product->old_price) * 100)); ?>% OFF
                            </span>
                        </p>
                    <?php else: ?>
                        <p class="price-display text-primary h2 fw-bold">R$ <?php echo e(number_format($product->price, 2, ',', '.')); ?></p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    
                    <small class="text-muted d-block mt-1">
                        <i class="bi bi-credit-card me-1"></i>
                        em até 12x de R$ <?php echo e(number_format($product->price / 12, 2, ',', '.')); ?> sem juros
                    </small>
                </div>

                <!-- Itens do Kit (Destaque) -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->bundleItems->count() > 0): ?>
                    <div class="card bg-light border-0 mb-4">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3 text-primary"><i class="bi bi-box-seam me-2"></i>Conteúdo do Kit:</h6>
                            <div class="list-group list-group-flush bg-white rounded shadow-sm">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $product->bundleItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="list-group-item d-flex align-items-center p-2 border-bottom">
                                        <div class="flex-shrink-0 me-3">
                                            <img src="<?php echo e($item->image ? (Str::startsWith($item->image, 'http') ? $item->image : asset('storage/' . $item->image)) : 'https://placehold.co/50x50'); ?>" 
                                                 alt="<?php echo e($item->name); ?>" 
                                                 class="rounded border"
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0 text-truncate" style="max-width: 250px;" title="<?php echo e($item->name); ?>"><?php echo e($item->name); ?></h6>
                                            <small class="text-muted"><?php echo e($item->pivot->quantity); ?> unidade(s)</small>
                                        </div>
                                        <div class="flex-shrink-0 ms-2">
                                            <a href="<?php echo e(route('shop.show', $item->slug)); ?>" class="btn btn-sm btn-light text-primary" target="_blank" title="Ver Produto">
                                                <i class="bi bi-box-arrow-up-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <!-- Descrição Curta (Marketing) -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->marketing_description): ?>
                    <p class="text-muted border-start border-3 border-primary ps-3 mb-4">
                        <?php echo e($product->marketing_description); ?>

                    </p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <hr class="mb-4">

                <!-- Seção de Variações (Alpine.js) -->
                <!-- Seção de Variações -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($colorVariants) > 0 || count($sizeVariants) > 0): ?>
                <div>
                    
                    <!-- Seleção de Cor -->
                    <?php if(count($colorVariants) > 0): ?>
                    <div class="mb-4">
                        <h6 class="fw-bold mb-2">
                            Cor: <span class="text-primary"><?php echo e($product->color); ?></span>
                        </h6>
                        <div class="d-flex gap-2 flex-wrap align-items-center">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $colorVariants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="position-relative text-center">
                                    <a href="<?php echo e(route('shop.show', $color['slug'])); ?>" 
                                       class="btn rounded-circle p-0 border-3 position-relative d-block mx-auto <?php echo e($color['active'] ? 'border-primary shadow' : 'border-secondary'); ?>" 
                                       style="width: 40px; height: 40px; transition: all 0.2s;"
                                       title="<?php echo e($color['name']); ?> (<?php echo e($color['stock']); ?> unidades)">
                                        <span class="d-block w-100 h-100 rounded-circle border border-2 border-white" 
                                              style="background-color: <?php echo e($color['hex']); ?>; opacity: <?php echo e($color['stock'] > 0 ? '1' : '0.3'); ?>;"></span>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($color['stock'] <= 0): ?>
                                            <span class="position-absolute top-50 start-50 translate-middle"
                                                  style="width: 2px; height: 45px; background: red; transform: translate(-50%, -50%) rotate(45deg);"></span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </a>
                                    <small class="d-block mt-1 <?php echo e($color['active'] ? 'fw-bold text-primary' : 'text-muted'); ?>" 
                                           style="font-size: 0.7rem;">
                                        <?php echo e($color['stock']); ?>

                                    </small>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <!-- Atributo (Campo Genérico) -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->attribute): ?>
                    <div class="mb-4">
                        <h6 class="fw-bold mb-2">Atributo:</h6>
                        <p class="text-muted mb-0">
                            <i class="bi bi-tag me-2"></i><?php echo e($product->attribute); ?>

                        </p>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <!-- Seleção de Tamanho -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($sizeVariants) > 0): ?>
                    <div class="mb-4">
                        <h6 class="fw-bold mb-2">
                            Tamanho: <span class="text-primary"><?php echo e($product->size); ?></span>
                        </h6>
                        <div class="d-flex flex-wrap gap-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $sizeVariants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('shop.show', $size['slug'])); ?>" 
                                   class="btn <?php echo e($size['active'] ? 'btn-primary' : 'btn-outline-secondary'); ?> <?php echo e($size['stock'] <= 0 ? 'disabled opacity-50' : ''); ?>"
                                   style="min-width: 60px;">
                                    <span class="fw-bold"><?php echo e($size['name']); ?></span>
                                    <small class="d-block" style="font-size: 0.7rem;">(<?php echo e($size['stock']); ?>)</small>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <!-- Seção de Quantidade e Ações -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->stock > 0): ?>
                    <div class="mb-4">
                        <label class="form-label fw-bold mb-2">Quantidade:</label>
                        
                        <?php echo $__env->make('livewire.shop.add-to-cart-button', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                        <small class="text-muted mt-2 d-block">
                            <i class="bi bi-box-seam me-1"></i><?php echo e($product->stock); ?> unidades disponíveis
                        </small>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                        <div>
                            Produto temporariamente indisponível.
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <hr class="mb-4">

                <!-- Informações Extras (Frete, Estoque) -->
                <div class="mt-4 p-3 bg-light rounded">
                    <p class="mb-1">
                        <i class="bi bi-box-seam me-2 text-primary"></i> 
                        Estoque: 
                        <span class="<?php echo e($product->stock > 0 ? 'text-success' : 'text-danger'); ?> fw-bold">
                            <?php echo e($product->stock > 0 ? 'Disponível' : 'Esgotado'); ?>

                        </span>
                    </p>
                    <p class="mb-0"><i class="bi bi-truck me-2 text-primary"></i> Frete Grátis acima de R$ 299,00</p>
                </div>

            </div>
        </div> <!-- Fim da Row Principal -->

    </div> <!-- Fim do Product Card Wrapper -->

    <!-- Seção de Abas (Descrição, Especificações, Avaliações) -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="bg-white p-4 rounded shadow-sm border">
                <ul class="nav nav-tabs" id="productDetailTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description-pane" type="button" role="tab" aria-controls="description-pane" aria-selected="true">Descrição Completa</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs-pane" type="button" role="tab" aria-controls="specs-pane" aria-selected="false">Especificações</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews-pane" type="button" role="tab" aria-controls="reviews-pane" aria-selected="false">Avaliações (128)</button>
                    </li>
                </ul>
                
                <div class="tab-content p-3 border border-top-0" id="productDetailTabsContent">
                    <!-- Aba Descrição -->
                    <div class="tab-pane fade show active" id="description-pane" role="tabpanel" aria-labelledby="description-tab">
                        <h4 class="h5 mb-3">Sobre o Produto</h4>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->description): ?>
                            <p><?php echo e($product->description); ?></p>
                        <?php else: ?>
                            <p class="text-muted">Descrição detalhada não disponível.</p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        
                        <h5 class="mt-4">Destaques</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><i class="bi bi-check-circle-fill text-success me-2"></i> Alta qualidade</li>
                            <li class="list-group-item"><i class="bi bi-check-circle-fill text-success me-2"></i> Design exclusivo</li>
                            <li class="list-group-item"><i class="bi bi-check-circle-fill text-success me-2"></i> Garantia de satisfação</li>
                        </ul>
                    </div>
                    
                    <!-- Aba Especificações -->
                    <div class="tab-pane fade" id="specs-pane" role="tabpanel" aria-labelledby="specs-tab">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th scope="row" style="width: 30%;">SKU</th>
                                    <td><?php echo e($product->sku ?? 'PROD-'.$product->id); ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Categoria</th>
                                    <td><?php echo e($product->category->name ?? 'Geral'); ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Peso</th>
                                    <td><?php echo e($product->weight ? $product->weight . ' kg' : 'N/A'); ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Garantia</th>
                                    <td><?php echo e($product->warranty ?? '90 dias'); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Aba Avaliações -->
                    <div class="tab-pane fade" id="reviews-pane" role="tabpanel" aria-labelledby="reviews-tab">
                        <h5 class="mb-3">Média de 4.5 / 5 Estrelas</h5>
                        <div class="list-group">
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">João Silva <span class="text-warning"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i></span></h6>
                                    <small class="text-muted">Há 2 dias</small>
                                </div>
                                <p class="mb-1 small">Produto excelente! Superou minhas expectativas.</p>
                            </div>
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Maria Souza <span class="text-warning"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></span></h6>
                                    <small class="text-muted">Há 1 semana</small>
                                </div>
                                <p class="mb-1 small">Entrega rápida e produto muito bem embalado.</p>
                            </div>
                        </div>
                        <div class="alert alert-info mt-3">
                            <i class="bi bi-info-circle me-2"></i>
                            Sistema de avaliações completo em breve.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- Fim da Row de Abas -->

    <!-- Produtos Relacionados -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($relatedProducts->count() > 0): ?>
        <div class="mt-5 pt-4 border-top">
            <h3 class="h4 mb-4">Produtos Relacionados</h3>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col">
                        <?php echo $__env->make('livewire.shop.product-card', ['product' => $related], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div>

<script>
// Function to change main product image when clicking thumbnails
function changeMainImage(src) {
    const mainImage = document.getElementById('mainProductImage');
    if (mainImage) {
        // Fade out effect
        mainImage.style.opacity = '0.5';
        
        setTimeout(() => {
            mainImage.src = src;
            mainImage.style.opacity = '1';
        }, 150);
        
        // Update active thumbnail
        document.querySelectorAll('.thumbnail-image').forEach(thumb => {
            thumb.classList.remove('active', 'border-primary', 'border-2');
            thumb.classList.add('border-secondary', 'opacity-75');
        });
        
        // Mark clicked thumbnail as active
        event.target.classList.add('active', 'border-primary', 'border-2');
        event.target.classList.remove('border-secondary', 'opacity-75');
        event.target.style.opacity = '1';
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.shop', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ecommerce\ecommerce-hp\resources\views/shop/show-kit.blade.php ENDPATH**/ ?>