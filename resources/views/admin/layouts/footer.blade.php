                <!-- Footer -->
                <footer class="content-footer footer bg-footer-theme">
                    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                        <div class="mb-2 mb-md-0">
                            ©
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            , Developed ❤️ by
                            <a href="#" target="_blank" class="footer-link fw-bolder">Rajib Sarder</a>
                        </div>

                    </div>
                </footer>
                <!-- / Footer -->

                {{-- single rating view modal  --}}

                <div class="modal fade quick-view-product" id="single-view-rating-modal" tabindex="-1"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                        class="far fa-times"></i></button>
                            </div>
                            <div class="modal-body">

                                <div class="single-product-thumb">
                                    <div class="row mb-5" style="margin-top: -10px">

                                        <h5 class="title">Review Details</h5>
                                        <div class="form-group">
                                            <p>
                                                <label>Email Id:</label>
                                                <span id="review_email"></span>
                                            </p>
                                            <p>
                                                <label>Name:</label>
                                                <span id="review_name"></span>
                                            </p>
                                            <p>
                                                <label>Rating:</label>
                                                <span id="review_rating"></span>
                                            </p>
                                            <p>
                                                <label>Comment:</label>
                                                <p id="review_comment"></p>
                                            </p>
                                            

                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>