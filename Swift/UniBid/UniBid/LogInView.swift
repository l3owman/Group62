//
//  LogInView.swift
//  UniBid
//
//  Created by Mario Yordanov on 9.04.21.
//

import UIKit
let forename: String = ""
let surname: String = ""

class LogInView: UIViewController, UITextFieldDelegate {

    override func viewDidLoad() {
        super.viewDidLoad()
        
        // Do any additional setup after loading the view.
        
        emailAddress.delegate = self
        password.delegate = self
        password.isSecureTextEntry = true
        
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
        
        var email = String(emailAddress.text!)
        var userPassword = String(password.text!)
        var alertMessageTitle = ""
        var alertMessage = ""
        
        if(email == "") {
            alertMessageTitle = "Email is a mandatory field"
            alertMessage = "Please enter a valid .ac.uk email adress."
            showAlert(alertMessageTitle, alertMessage)
        }
        else if(userPassword == "") {
            alertMessageTitle = "Password is a mandatory field"
            alertMessage = "Please enter your password."
            showAlert(alertMessageTitle, alertMessage)
        } else {
        
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
                        let result = convertStringToDictionary(text: responseString!)
                        print(result)
                        
                        self.executeSegue()
                    } else {
                        self.showAlert("Wrong credentials", "Wrong email or password.")
                    }
                }

                task.resume()
        }
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
    
    func showAlert(_ messageTitle: String, _ message: String) {
        DispatchQueue.main.async {
            let alert = UIAlertController(title: messageTitle, message: message, preferredStyle: .alert)
            alert.addAction(UIAlertAction(title: "OK", style: .default, handler: nil))
            self.present(alert, animated: true, completion: nil)
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
func convertStringToDictionary(text: String) -> [String:AnyObject]? {
   if let data = text.data(using: .utf8) {
       do {
           let json = try JSONSerialization.jsonObject(with: data, options: .mutableContainers) as? [String:AnyObject]
           return json
       } catch {
           print("Something went wrong")
       }
   }
   return nil
}

