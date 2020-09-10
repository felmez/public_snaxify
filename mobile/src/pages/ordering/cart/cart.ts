import { Component, ViewChild } from '@angular/core';
import { AlertController, IonicPage, ModalController, NavController, Platform, Slides } from 'ionic-angular';
import { CartService } from '../../../services/cart_service';
import { APIService } from '../../../services/api_service';
import { TranslateService } from '@ngx-translate/core';

/**
 * Cart page component
 */
@IonicPage()
@Component({
  selector: 'cart',
  templateUrl: 'cart.html'
})
export class CartPage {

  public items;
  public loggedIn = false;
  @ViewChild(Slides) slides: Slides;
  public direction = 'ltr';

  constructor(
    public cart: CartService,
    private modalCtrl: ModalController,
    private platform: Platform,
    private navCtrl: NavController,
    private alertCtrl: AlertController,
    private apiService: APIService,
    private translate: TranslateService
  ) {
    this.items = cart.getItems();
    cart.itemsCount$.subscribe((v) => {
      this.items == cart.getItems();
    });
    this.loggedIn = this.apiService.isLoggedIn();
    this.direction = this.platform.dir();
  }

  ionViewWillEnter() {
    this.items = this.cart.getItems();
  }

  increaseCart(item): any {
    this.cart.setItemCount(item.product, item.count + 1);
  }

  decreaseCart(item): any {
    if (item.count == 1) {
      let alert = this.alertCtrl.create({
        title: this.translate.instant('cart.remove_from_cart'),
        message: this.translate.instant('cart.do_you_want_to_remove_this_product_at_all'),
        buttons: [
          {
            text: this.translate.instant('buttons.cancel'),
            role: 'cancel',
            handler: () => {
              // console.log('Cancel clicked');
            }
          },
          {
            text: this.translate.instant('buttons.ok'),
            handler: () => {
              this.cart.removeItem(item);
              this.slides.slideTo(0, 500);
            }
          }
        ]
      });
      alert.present();
    }
    else {
      this.cart.setItemCount(item.product, item.count - 1);
    }
  }

  showOrderModal() {
    this.navCtrl.push('OrderPage');
  }

  cartPrice() {
    let result = 0;
    this.items.forEach((item) => {
      result = result + item.product.price * item.count;
    });
    return result;
  }

  cartTax() {
    let result = 0;
    this.cart.getItems().forEach((item) => {
      result = result + item.product.price * item.product.tax_value / 100 * item.count;
    });
    return result;
  }

  cartWithTax() {
    if (this.apiService.getSettings().tax_included) {
      return this.cartPrice();
    }
    else {
      return this.cartTax() + this.cartPrice();
    }
  }
}
