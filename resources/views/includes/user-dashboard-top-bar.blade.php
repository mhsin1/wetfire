<div class="dashboard-upper-info">
                        <div class="row align-items-center no-gutters">
                            <div class="col-xl-3 col-lg-3 col-md-6">
                                <div class="d-single-info">
                                    <p class="user-name">Welcome <span>{{Auth::user()->name}}</span></p>
                                    <p>(not {{ Auth::user()->email }}? <a class="log-out" href="{{ route('user-logout') }}">Log Out</a>)</p>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="d-single-info">
                                    <p>Need Assistance? Customer service at.</p>
                                    <p>{{ $ps->contact_email }}</p>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6">
                                <div class="d-single-info">
                                    <p>E-mail them at </p>
                                    <p>{{ $ps->email }}</p>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-2 col-md-6">
                                <div class="d-single-info text-lg-center">
                                    <a class="view-cart" href="{{ route('front.cart') }}">view cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
