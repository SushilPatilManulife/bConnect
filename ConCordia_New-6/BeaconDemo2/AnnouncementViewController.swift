//
//  AnnouncementViewController.swift
//  BeaconDemo2
//
//  Created by sushil on 2017-08-12.
//  Copyright © 2017 Animatronic Gopher Inc. All rights reserved.
//

import UIKit

class AnnouncementViewController: UIViewController {
    @IBOutlet weak var lblOfferName: UILabel!
    
    @IBOutlet weak var offerImageView: UIImageView!
    @IBOutlet weak var lblOfferDetail: UILabel!
    var offer : Offer!
    override func viewDidLoad() {
        super.viewDidLoad()
        self.navigationItem.title = CATEGORY_ANNOUNCEMENT_KEY
        // Do any additional setup after loading the view.
        if offer != nil {
            self.lblOfferName.text = self.offer.name.capitalized
            self.lblOfferDetail.text = self.offer.entry_descriptions
            let img = WebServiceManager.sharedInstance.readImageFromLocally(imageName: offer.imageName.lowercased())
            self.offerImageView.image = img != nil ? img : UIImage(named: "Splash")
            self.offerImageView.layer.cornerRadius = 10.0
            self.offerImageView.clipsToBounds = true
        }
        
    }
    

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    

    /*
    // MARK: - Navigation

    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
        // Get the new view controller using segue.destinationViewController.
        // Pass the selected object to the new view controller.
    }
    */

}
