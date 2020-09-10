import { Component } from '@angular/core';
import { APIService } from '../../../services/api_service';
import { CartService } from '../../../services/cart_service';
import { IonicPage, NavController, NavParams, Platform } from 'ionic-angular';
import { stringify } from '@angular/core/src/util';
//import { SingleProductPage } from '../single-product/single-product';

/**
 * Products list page component
 */
@IonicPage()
@Component({
  selector: 'products',
  templateUrl: 'products.html'
})
export class ProductsPage {
  public direction = 'ltr';
  public products;
  public initialProducts;
  public category;
  public searchQ = '';
  private items;
  // private _itemsCount$: Subject<number>;

  constructor(
    private nav: NavController,
    private apiService: APIService,
    private navCtrl: NavController,
    private params: NavParams,
    private cart: CartService,
    private platform: Platform,

  ) {
    this.direction = platform.dir();
    this.products = [];
    this.category = params.get('category');
    if (this.category == null) {
      location.href = '/';
    }
    
  }

  ionViewWillEnter() {
    if (this.category == null) {
      return;
    }
    this.apiService.getProducts(this.category.id).then((response) => {
      this.products = response.json();
      this.initialProducts = response.json();
      for (let i = 0; i < this.products.length; i++) {
        this.products[i].added = this.cart.hasItem(this.products[i]);
      }

    });
  }

  onSearchInput($event) {
    this.products = this.initialProducts.filter(p => {
      return p.name.toLowerCase().indexOf(this.searchQ.toLowerCase()) >= 0;
    });
  }
/*
  plus and minus buttons functions, koudify
*/
  addToCart(product) {
    this.cart.addItem(product, 1);
    product.added = true;
  }
  
  decreaseCart(product): any {
    /*this.cart.getItems().forEach(cart_item => {
       if (cart_item.product.id == product.id) {
         foundItem=cart_item;      
        }
      });
   */
    let foundItem; 
    let inCartItems=this.cart.getItems();
/*
      finding the same item in cart to pass it to removeItem() in order to remove it
*/
    for (var i = 0; i < inCartItems.length; i++) {
      if (inCartItems[i].product.id == product.id) {
        //console.log('match found:'+inCartItems[i].product.id+' -- '+product.id); 
        foundItem=inCartItems[i];
        break;
      }
     // console.log('no match!.');
    }
    if (foundItem.count == 1) {
      this.cart.removeItem(foundItem);
      product.added = false;
    }          
    else {
      this.cart.setItemCount(product, foundItem.count - 1);
    }
  }

  // }
// kodify
  // open(product) {
  //   this.navCtrl.push('SingleProductPage', {item: product});
  // }
  
 
}
