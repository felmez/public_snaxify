import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams, Platform } from 'ionic-angular';
import { APIService } from '../../../services/api_service';
import { CartService } from '../../../services/cart_service';

/**
 * Products list page component
 */
@IonicPage()
@Component({
  selector: 'single-product',
  templateUrl: 'single-product.html'
})
export class SingleProductPage {
  public direction = 'ltr';
  public product;

  constructor(
    private nav: NavController,
    private apiService: APIService,
    private params: NavParams,
    private cart: CartService,
    private platform: Platform
  ) {
    this.direction = platform.dir();
    this.product = params.get('item');
    this.product.added = this.cart.hasItem(this.product);
  }

  ionViewWillEnter() {

  }

  addToCart(product) {
    this.cart.addItem(product, 1);
    product.added = true;
  }
}
