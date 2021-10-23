<div class="product-item">
<a href="{{ route('front.product', $prod->slug) }}">

                        <div class="pi-pic">
                            <img src="{{ $prod->thumbnail ? asset('public/assets/images/thumbnails/'.$prod->thumbnail):asset('public/assets/images/noimage.png') }}" alt="">
                            <div class="icon">
                                <i class="icon_heart_alt"></i>
                            </div>
                        </div>
                        <div class="pi-text">
                            <div class="catagory-name">Coat</div>
                            <a href="{{ route('front.product', $prod->slug) }}">
                                <h5>{{ $prod->showName() }}</h5>
                            </a>
                            <div class="product-price">
							{{ $prod->showPrice() }}
                                <span>{{ $prod->showPreviousPrice() }}</span>
                            </div>
                        </div>
						</a>
					</div>
