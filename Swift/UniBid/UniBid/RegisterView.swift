//
//  RegisterView.swift
//  UniBid
//
//  Created by Mario Yordanov on 9.04.21.
//

import UIKit

class RegisterView: UIViewController, UITextFieldDelegate {

    override func viewDidLoad() {
        super.viewDidLoad()

        // Do any additional setup after loading the view.
        emailAddress.delegate = self
        password.delegate = self
        confirmPassword.delegate = self
        forename.delegate = self
        surname.delegate = self
        address.delegate = self
        postcode.delegate = self
        
        let tap = UITapGestureRecognizer(target: self, action: #selector(handleTap))
                view.addGestureRecognizer(tap) // Add gesture recognizer to background view
    }
    
    // Objects
    @objc func handleTap() {
        emailAddress.resignFirstResponder() // dismiss keyboard
        password.resignFirstResponder()
        confirmPassword.resignFirstResponder()
        forename.resignFirstResponder()
        surname.resignFirstResponder()
        address.resignFirstResponder()
        postcode.resignFirstResponder()
        }
    
    // Outlets
    @IBOutlet weak var emailAddress: UITextField!
    @IBOutlet weak var password: UITextField!
    @IBOutlet weak var confirmPassword: UITextField!
    @IBOutlet weak var forename: UITextField!
    @IBOutlet weak var surname: UITextField!
    @IBOutlet weak var address: UITextField!
    @IBOutlet weak var postcode: UITextField!
    
    
    // Actions
    @IBAction func registerButton(_ sender: Any) {
    }
    
    
    // UITextFieldDelegete Methods
    func textFieldShouldReturn(_ textField: UITextField) -> Bool {
        emailAddress.resignFirstResponder() // dismiss keyboard
        password.resignFirstResponder()
        confirmPassword.resignFirstResponder()
        forename.resignFirstResponder()
        surname.resignFirstResponder()
        address.resignFirstResponder()
        postcode.resignFirstResponder()
        return true
    }
    
    /*
    // MARK: - Navigation

    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
        // Get the new view controller using segue.destination.
        // Pass the selected object to the new view controller.
    }
    */

}
