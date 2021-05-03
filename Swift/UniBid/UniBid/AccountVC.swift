//
//  AccountVC.swift
//  UniBid
//
//  Created by Mario Yordanov on 3.05.21.
//

import UIKit

class AccountVC: UIViewController, UITableViewDelegate, UITableViewDataSource {

    var sections = [tableSections]()
    @IBOutlet weak var nameLabel: UILabel!
    @IBOutlet weak var emailLabel: UILabel!
    @IBOutlet weak var tableView: UITableView!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        nameLabel.text? = "Hello, " + "Mario Yordanov"
        emailLabel.text? = "mario.yordanov@livuni.ac.uk"
        //self.tableView.tableFooterView = UIView(frame: CGRect.zero)
        
        sections.append(tableSections.init(section: "Account", options: ["Edit Profile", "Log Out"]))
        sections.append(tableSections.init(section: "Listings", options: ["Wishlist", "Won Auctions", "Archived Auctions", "Add Auction", "Bids"]))
        sections.append(tableSections.init(section: "Finance", options: ["Wallet", "Statistics", "Payments"]))
        // Do any additional setup after loading the view.
    }
    
    func numberOfSections(in tableView: UITableView) -> Int {
        return sections.count
    }
    
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        
        return sections[section].options?.count ?? 0
    }
    
    func tableView(_ tableView: UITableView, viewForHeaderInSection section: Int) -> UIView? {
        let view = UIView(frame: CGRect(x: 0, y: 0, width: tableView.frame.width, height: 60))
        view.backgroundColor = .red
        
        let lbl = UILabel(frame: CGRect(x: 15, y: 0, width: view.frame.width - 15, height: 60))
               lbl.font = UIFont.systemFont(ofSize: 34)
               lbl.text = sections[section].section
               view.addSubview(lbl)
        return view
    }
    
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCell(withIdentifier: "myCell", for: indexPath)
        cell.textLabel?.text = sections[indexPath.section].options?[indexPath.row]
        cell.accessoryType = UITableViewCell.AccessoryType.disclosureIndicator
        return cell
    }
    
    func tableView(_ tableView: UITableView, heightForHeaderInSection section: Int) -> CGFloat {
           return 60
    }
         
    func tableView(_ tableView: UITableView, heightForRowAt indexPath: IndexPath) -> CGFloat {
           return 40
    }
    
    func tableView(_ tableView: UITableView, didSelectRowAt indexPath: IndexPath) {
        
        var selectednSectionIndex = indexPath.section
        var selectedCellIndex = indexPath.row

        if(selectednSectionIndex == 0 && selectedCellIndex == 1) {
            let vc = self.storyboard?.instantiateViewController(identifier: "LogInViewController") as! LogInView
            vc.modalPresentationStyle = .fullScreen
            self.present(vc, animated: true, completion: nil)
        }
        if(selectednSectionIndex == 1 && selectedCellIndex == 3) {
            let vc = self.storyboard?.instantiateViewController(identifier: "addAuctionViewController") as! addAuctionView
            vc.modalPresentationStyle = .fullScreen
            self.present(vc, animated: true, completion: nil)
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


class tableSections {
   var section: String?
   var options: [String]?
     
   init(section: String, options: [String]) {
       self.section = section
       self.options = options
   }
}
