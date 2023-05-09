from flask import Flask, render_template , send_file

app = Flask(__name__)

@app.route('/')

def home():
    return render_template('menuptimization.html')

@app.route('/download')

def download_file():
    p = "./files/feature_one.csv"
    return send_file(p , as_attachment = True)


if __name__ == '__main__':
    app.run(debug=True)
    
    