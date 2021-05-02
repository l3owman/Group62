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
        let email = String(emailAddress.text!)
        let userPassword = String(password.text!)
        
        let parameters = [ "email":email, "password":userPassword]
        
        let url = URL(string: "https://student.csc.liv.ac.uk/~sglbowma/api/login.php")!
                var request = URLRequest(url: url)
                request.setValue("application/x-www-form-urlencoded", forHTTPHeaderField: "Content-Type")
                request.httpMethod = "POST"
                request.httpBody = parameters.percentEncoded()

                let task = URLSession.shared.dataTask(with: request) { data, response, error in
                    guard let data = data,
                        let response = response as? HTTPURLResponse,
                        error == nil else {                                              // check for fundamental networking error
                        print("error", error ?? "Unknown error")
                        return
                    }

                    guard (200 ... 299) ~= response.statusCode else {                    // check for http errors
                        print("statusCode should be 2xx, but is (response.statusCode)")
                        print("response = \(response)")
                        return
                    }

                    let responseString = String(data: data, encoding: .utf8)
                    print("responseString = \(responseString)")
                    if(responseString != ""){
                        self.executeSegue()
                    }
                }

                task.resume()
    }
    
    // Methods

    // UITextFieldDelegete Methods
    func textFieldShouldReturn(_ textField: UITextField) -> Bool {
        emailAddress.resignFirstResponder() // dismiss keyboard
        password.resignFirstResponder()
        return true
    }
    
    func executeSegue(){
        DispatchQueue.main.async {
           // UI work here
            self.performSegue(withIdentifier: "toBrowsePage", sender: nil)
        }
        
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
extension Dictionary {
    func percentEncoded() -> Data? {
        return map { key, value in
            let escapedKey = "\(key)".addingPercentEncoding(withAllowedCharacters: .urlQueryValueAllowed) ?? ""
            let escapedValue = "\(value)".addingPercentEncoding(withAllowedCharacters: .urlQueryValueAllowed) ?? ""
            return escapedKey + "=" + escapedValue
        }
        .joined(separator: "&")
        .data(using: .utf8)
    }
}

extension CharacterSet {
    static let urlQueryValueAllowed: CharacterSet = {
        let generalDelimitersToEncode = ":#[]@" // does not include "?" or "/" due to RFC 3986 - Section 3.4
        let subDelimitersToEncode = "!$&'()*+,;="

        var allowed = CharacterSet.urlQueryAllowed
        allowed.remove(charactersIn: "\(generalDelimitersToEncode)\(subDelimitersToEncode)")
        return allowed
    }()
}


