//
//  LogInView.swift
//  UniBid
//
//  Created by Mario Yordanov on 9.04.21.
//

import UIKit

class LogInView: UIViewController, UITextFieldDelegate {

    override func viewDidLoad() {
        super.viewDidLoad()
        
        // Do any additional setup after loading the view.
        
        emailAddress.delegate = self
        password.delegate = self
        
        let tap = UITapGestureRecognizer(target: self, action: #selector(handleTap))
                view.addGestureRecognizer(tap) // Add gesture recognizer to background view
    
    }
    
    // Objects
    @objc func handleTap() { // Used so when a user clicks outside of a text field the keyboard hides
            emailAddress.resignFirstResponder() // dismiss keyoard
            password.resignFirstResponder()
        }
    
    // Outlets
    @IBOutlet weak var emailAddress: UITextField!
    @IBOutlet weak var password: UITextField!
    
    // Actions
    @IBAction func forgotPasswordButton(_ sender: UIButton) {
    }
    
    @IBAction func logInButton(_ sender: Any) {
    }
    
    // Methods

    // UITextFieldDelegete Methods
    func textFieldShouldReturn(_ textField: UITextField) -> Bool {
        emailAddress.resignFirstResponder() // dismiss keyboard
        password.resignFirstResponder()
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


