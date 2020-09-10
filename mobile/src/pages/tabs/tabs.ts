import { Component } from '@angular/core';

import { CartService } from '../../services/cart_service';
import { APIService } from '../../services/api_service';

/**
 * Tabs primary component
 */
@Component({
  templateUrl: 'tabs.html'
})
export class TabsPage {
  // this tells the tabs component which Pages
  // should be each tab's root Page
  // redirected to restaurants page with tabs
  tabHomePage: any = 'RestaurantsPage';
  tabCategoriesPage: any = 'CategoriesPage';
  tabCartPage: any = 'CartPage';
  tabOrdersPage: any = 'OrdersHistoryPage';
  tabProfileRoot: any = 'ProfilePage';
  count: number = 0;

  constructor(
    private cart: CartService,
    private apiService: APIService
  ) {
    this.count = cart.getCartCount();
    if (this.apiService.getSettings().multiple_restaurants) {
      this.tabCategoriesPage = 'RestaurantsPage';
    }

    this.cart.itemsCount$.subscribe((v) => {
      this.count = v;
    });
  }


}
