import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

void main() {
  runApp(CareBridgeApp());
}

//////////////////////////////////////////////////////
// APP ROOT
//////////////////////////////////////////////////////
class CareBridgeApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Care Bridge',
      theme: ThemeData(
        primarySwatch: Colors.pink,
        textTheme: GoogleFonts.robotoSerifTextTheme(),
      ),
      home: IntroScreen(),
    );
  }
}

//////////////////////////////////////////////////////
// COLORS
//////////////////////////////////////////////////////
const primaryPink = Color(0xFFE91E63);
const lightPink = Color(0xFFFCE4EC);

//////////////////////////////////////////////////////
// COMMON APPBAR
//////////////////////////////////////////////////////
AppBar buildAppBar(BuildContext context, String title) {
  return AppBar(
    title: Text(title),
    backgroundColor: primaryPink,
    centerTitle: true,
    leading: IconButton(
      icon: Icon(Icons.arrow_back),
      onPressed: () => Navigator.pop(context),
    ),
    actions: [
      IconButton(
        icon: Icon(Icons.home),
        onPressed: () {
          Navigator.pushAndRemoveUntil(
            context,
            MaterialPageRoute(builder: (_) => HomeScreen()),
            (route) => false,
          );
        },
      )
    ],
  );
}

//////////////////////////////////////////////////////
// SIGNATURE
//////////////////////////////////////////////////////
Widget appSignature() {
  return Padding(
    padding: const EdgeInsets.only(bottom: 10),
    child: Text(
      "© 2026 Care Bridge • Duclas Matsinhe",
      style: TextStyle(fontSize: 12, color: Colors.grey),
    ),
  );
}

//////////////////////////////////////////////////////
// INTRO SCREEN
//////////////////////////////////////////////////////
class IntroScreen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: lightPink,
      body: SafeArea(
        child: Padding(
          padding: EdgeInsets.all(20),
          child: Stack(
            children: [

              // 🌸 BACKGROUND IMAGE
              Positioned(
                right: -80,
                top: 140,
                child: Opacity(
                  opacity: 0.85,
                  child: Image.asset(
                    "assets/images/home.png",
                    height: 420,
                  ),
                ),
              ),

              // CONTENT
              Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [

                  Center(
                    child: Text(
                      "Care Bridge",
                      style: TextStyle(
                        fontSize: 18,
                        fontWeight: FontWeight.bold,
                        color: primaryPink,
                      ),
                    ),
                  ),

                  SizedBox(height: 50),

                  Text(
                    "Together, We\nCreate Change",
                    style: TextStyle(
                      fontSize: 34,
                      fontWeight: FontWeight.bold,
                      color: primaryPink,
                    ),
                  ),

                  SizedBox(height: 15),

                  SizedBox(
                    width: MediaQuery.of(context).size.width * 0.6,
                    child: Text(
                      "Millions lack access to menstrual hygiene products. "
                      "Care Bridge is here to bridge the gap with care and compassion.",
                      style: TextStyle(color: Colors.grey[700]),
                    ),
                  ),

                  SizedBox(height: 60),

                  ElevatedButton(
                    onPressed: () {
                      Navigator.push(
                        context,
                        MaterialPageRoute(builder: (_) => HomeScreen()),
                      );
                    },
                    child: Text("Get Started"),
                    style: ElevatedButton.styleFrom(
                      backgroundColor: primaryPink,
                      padding: EdgeInsets.symmetric(
                          horizontal: 28, vertical: 14),
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(30),
                      ),
                    ),
                  ),

                  Spacer(),

                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceAround,
                    children: [
                      feature(context, Icons.people, "Help Others"),
                      feature(context, Icons.health_and_safety, "Health & Dignity"),
                      feature(context, Icons.favorite, "Stronger Together"),
                    ],
                  ),

                  SizedBox(height: 10),
                  Center(child: appSignature()),
                ],
              ),
            ],
          ),
        ),
      ),
    );
  }

  Widget feature(BuildContext context, IconData icon, String text) {
    return GestureDetector(
      onTap: () {
        Navigator.push(
          context,
          MaterialPageRoute(builder: (_) => HomeScreen()),
        );
      },
      child: Column(
        children: [
          CircleAvatar(
            backgroundColor: Colors.pink.shade100,
            child: Icon(icon, color: primaryPink),
          ),
          SizedBox(height: 5),
          Text(text, style: TextStyle(fontSize: 12)),
        ],
      ),
    );
  }
}

//////////////////////////////////////////////////////
// HOME SCREEN (FIXED)
//////////////////////////////////////////////////////
class HomeScreen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: lightPink,
      appBar: buildAppBar(context, "Care Bridge"),
      body: Padding(
        padding: EdgeInsets.all(20),
        child: Column(
          children: [

            SizedBox(height: 20),

            Text(
              "Ending Period Poverty",
              textAlign: TextAlign.center,
              style: TextStyle(
                fontSize: 26,
                fontWeight: FontWeight.bold,
                color: primaryPink,
              ),
            ),

            SizedBox(height: 12),

            Text(
              "Care Bridge connects donors with those in need.\nTogether, we ensure dignity and health for everyone.",
              textAlign: TextAlign.center,
              style: TextStyle(color: Colors.grey[700]),
            ),

            SizedBox(height: 40),

            actionCard(context, "Donate", "Support someone in need", Icons.favorite),
            actionCard(context, "Request Help", "Get products", Icons.volunteer_activism),
            actionCard(context, "Register", "Create account", Icons.person_add, isRegister: true),

            Spacer(),

            appSignature(),
          ],
        ),
      ),
    );
  }

  Widget actionCard(BuildContext context, String title, String subtitle, IconData icon, {bool isRegister = false}) {
    return GestureDetector(
      onTap: () {
        if (isRegister) {
          Navigator.push(context, MaterialPageRoute(builder: (_) => RegisterScreen()));
        } else {
          Navigator.push(context, MaterialPageRoute(builder: (_) => LoginScreen()));
        }
      },
      child: Container(
        margin: EdgeInsets.symmetric(vertical: 10),
        padding: EdgeInsets.all(16),
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(20),
          boxShadow: [BoxShadow(color: Colors.black12, blurRadius: 8)],
        ),
        child: Row(
          children: [
            CircleAvatar(
              backgroundColor: lightPink,
              child: Icon(icon, color: primaryPink),
            ),
            SizedBox(width: 15),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(title, style: TextStyle(fontWeight: FontWeight.bold)),
                  Text(subtitle, style: TextStyle(color: Colors.grey)),
                ],
              ),
            ),
            Icon(Icons.arrow_forward_ios, size: 16),
          ],
        ),
      ),
    );
  }
}

//////////////////////////////////////////////////////
// LOGIN
//////////////////////////////////////////////////////
class LoginScreen extends StatelessWidget {
  final TextEditingController emailController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();

  Future<void> loginUser(BuildContext context) async {
    var url = Uri.parse("http://10.0.2.2:8081/CareBridgeProject/backend/login_API.php");

    try {
      var response = await http.post(url, body: {
        "email": emailController.text,
        "password": passwordController.text,
      });

      var data = json.decode(response.body);

      if (data["status"] == "success") {
        String role = data["user"]["role"];
        String name = data["user"]["name"];
        int userId = int.parse(data["user"]["id"].toString());

        if (role == "donor") {
          Navigator.pushReplacement(
            context,
            MaterialPageRoute(builder: (_) => DonorScreen(name: name, userId: userId)),
          );
        } else {
          Navigator.pushReplacement(
            context,
            MaterialPageRoute(builder: (_) => ReceptorScreen(name: name)),
          );
        }
      } else {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text(data["message"])),
        );
      }
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text("Connection error")),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: lightPink,
      appBar: buildAppBar(context, "Login"),
      body: Padding(
        padding: EdgeInsets.all(20),
        child: Column(
          children: [
            SizedBox(height: 30),
            Text("Care Bridge", style: TextStyle(fontSize: 28, color: primaryPink)),
            SizedBox(height: 20),
            TextField(controller: emailController, decoration: InputDecoration(labelText: "Email")),
            SizedBox(height: 15),
            TextField(controller: passwordController, obscureText: true, decoration: InputDecoration(labelText: "Password")),
            SizedBox(height: 20),
            ElevatedButton(
              onPressed: () => loginUser(context),
              child: Text("Login"),
              style: ElevatedButton.styleFrom(backgroundColor: primaryPink),
            ),
            Spacer(),
            appSignature(),
          ],
        ),
      ),
    );
  }
}

//////////////////////////////////////////////////////
// OTHER SCREENS
//////////////////////////////////////////////////////
class RegisterScreen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: buildAppBar(context, "Register"),
      body: Center(child: Text("Registration via website")),
    );
  }
}

class DonorScreen extends StatelessWidget {
  final String name;
  final int userId;

  DonorScreen({required this.name, required this.userId});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: buildAppBar(context, "Donor Dashboard"),
      body: Center(child: Text("Welcome, $name")),
    );
  }
}

class ReceptorScreen extends StatelessWidget {
  final String name;

  ReceptorScreen({required this.name});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: buildAppBar(context, "Receptor Dashboard"),
      body: Center(child: Text("Welcome Receptor, $name")),
    );
  }
}