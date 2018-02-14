//
//  ApartmentViewController.swift
//  BeaconDemo2
//
//  Created by sushil on 2017-08-12.
//  Copyright © 2017 Animatronic Gopher Inc. All rights reserved.
//

import UIKit

class ApartmentViewController: UIViewController , UITextFieldDelegate{

    @IBOutlet weak var loadingView: UIView!
    var offer : Offer!

    @IBOutlet weak var indicator: UIActivityIndicatorView!
    @IBOutlet weak var txtNumber: UITextField!
    @IBOutlet weak var txtName: UITextField!
    @IBOutlet weak var lblDetails: UILabel!
    @IBOutlet weak var lblName: UILabel!
    @IBOutlet weak var imageView: UIImageView!
    override func viewDidLoad() {
        super.viewDidLoad()
        self.navigationItem.title = CATEGORY_APPARTMENT_KEY
        if offer != nil {
            self.lblName.text = self.offer.name.capitalized
            self.lblDetails.text = self.offer.entry_descriptions
            let img = WebServiceManager.sharedInstance.readImageFromLocally(imageName: offer.imageName.lowercased())
            self.imageView.image = img != nil ? img : UIImage(named: "Splash")
        }
        self.txtNumber.keyboardType = .numberPad
        self.txtNumber.delegate = self
        self.txtName.delegate = self
  self.loadingView.isHidden = true
        
        // Do any additional setup after loading the view.
    }

    @IBAction func btnOkClicked(_ sender: Any) {
        self.saveData()
        
    }
    @IBAction func btnCloseClicked(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    func saveData() -> Void {
        self.loadingView.isHidden = false
        self.indicator.startAnimating()
        DispatchQueue.global().async {
           
            WebServiceManager.sharedInstance.saveUserInfo(user_name: (self.txtName.text?.capitalized)!, mobile: self.txtNumber.text!, notification_id: String(self.offer.nid), complitionHandler: { (result, sucess, err) in
                DispatchQueue.main.async(execute: {
                    self.loadingView.isHidden = true
                    self.indicator.stopAnimating()
                    self.navigationController?.popViewController(animated: true)
                })

            })
            
        }
    }
    
    func textFieldShouldReturn(_ textField: UITextField) -> Bool {
        textField.resignFirstResponder()
        return true
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
