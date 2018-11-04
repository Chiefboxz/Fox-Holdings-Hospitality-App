package za.co.lecafeperk.lecafeperk.Adapters;

import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.drawable.ColorDrawable;
import android.os.AsyncTask;
import android.provider.MediaStore;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.v4.content.ContextCompat;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.backendless.Backendless;
import com.bumptech.glide.Glide;
//import com.bumptech.glide.Glide;

import java.io.BufferedInputStream;
import java.io.IOException;
import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.nio.file.Files;
import java.util.Iterator;
import java.util.List;

import za.co.lecafeperk.lecafeperk.Entities.Menu;
import za.co.lecafeperk.lecafeperk.MainActivity;
import za.co.lecafeperk.lecafeperk.R;

import static android.support.v4.content.ContextCompat.startActivity;

public class MenuAdapter extends ArrayAdapter<Menu> {
    private Context context;
    private List<Menu> MenuList;
    ImageView Mimage;


    public MenuAdapter(Context context, List<Menu> list){
        super(context, R.layout.list_menu, list);
        this.context = context;
        this.MenuList = list;
    }

    //@NonNull
    @Override
    public View getView(int position, View convertView, ViewGroup parent) {

        LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

        convertView = inflater.inflate(R.layout.list_menu, parent, false);
        //String url = convertView.findViewById(R.id.Mimage).toString();
        //TextView Mimage = convertView.findViewById(R.id.Mimage);
        Mimage = (ImageView)convertView.findViewById(R.id.Mimage);
        TextView MItem = convertView.findViewById(R.id.MItem);
        TextView MPrice = convertView.findViewById(R.id.MPrice);
        //first should be an image/bitmap image of the file in backendless........

        //cant figure out the image fetch from backendless...


        displayImage(position);

//        new DownloadImageTask((ImageView) convertView.findViewById(R.id.Mimage))
//                .execute(MenuList.get(position).getImage());
        //ImageView imageView = (ImageView) convertView.findViewById(R.id.Mimage);
    String urls = MenuList.get(position).getImage();



        System.out.println(urls+"the first url check!!!!!!");
//        Glide.with(getContext())
//                .load("https://api.backendless.com/A7414F49-A103-12EA-FF8B-1A3A7A91F100/6B66E749-4266-0A7B-FFDD-AED332608C00/files/images/cofee.jpg")
//                //.placeholder(new ColorDrawable(ContextCompat.getColor(MenuAdapter.this, R.color.placeholder_gray)))
//                //.error(new ColorDrawable(ContextCompat.getColor(getContext(), R.color.cardview_dark_background)))
//                .into(imageView);
//        System.out.println(url+"next url checkkkkk");
        //Glide.with(getContext()).load(MenuList.get(position).getImage()).into(Mimage);
        MItem.setText(MenuList.get(position).getMenuName());
        MPrice.setText("R"+MenuList.get(position).getPrice()+ "");

        return convertView;
    }


    private void displayImage(int position){
        String imageLocation = MenuList.get(position).getImage();
        System.out.println(imageLocation+"  imageLocation that is recieved... ... ...");
        try {
            System.out.println("below is the image url...");
            System.out.println(imageLocation);
            URL url = new URL(imageLocation);
            //TODO: geet the image at this url and display it.
            DownloadFilesTask task = new DownloadFilesTask();
            task.execute(url);
        } catch (MalformedURLException e) {
            e.printStackTrace();
        }


    }

    private void displayPopupImage(Bitmap bitmap){
        AlertDialog.Builder imageDialog = new AlertDialog.Builder(getContext());
        imageDialog.setMessage("  image testersss");

        imageDialog.setNegativeButton("Close", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialogInterface, int i) {

            }
        });

        //ImageView Mimage = (ImageView) findViewById(R.id.Mimage);
        Mimage.setImageBitmap(bitmap);

        ImageView imageView = new ImageView(getContext());
        imageView.setImageBitmap(bitmap);
        imageDialog.setView(imageView);

        imageDialog.create();
        imageDialog.show();
    }

    private class DownloadFilesTask extends AsyncTask<URL, Void, Bitmap>{


        @Override
        protected Bitmap doInBackground(URL... urls) {
            System.out.println(urls+" This is the urls check in the bitmap image check.....");
            for (URL url : urls) {
                System.out.println(url+" ..url..");
                System.out.println(urls + " ...urls...");
                try {
                    System.out.println("Does it arrive here"+ urls);
                    HttpURLConnection httpCon = (HttpURLConnection)url.openConnection();
                    System.out.println(httpCon + ".....httpCon.....");
                    //httpCon.setRequestMethod("GET");
                    httpCon.connect();
                    int responseCode = httpCon.getResponseCode();
                    System.out.println(responseCode+"----responseCode.--------");
                    System.out.println("check check check cehck!!!!");
                    if(responseCode == HttpURLConnection.HTTP_OK){
                        InputStream inputStream = httpCon.getInputStream();
                        Bitmap imageBitmap = BitmapFactory.decodeStream(inputStream);
                        System.out.println("in the http response 111111");
                        System.out.println(urls);
                        inputStream.close();

                        return imageBitmap;

                    }
                } catch (IOException e) {
                    e.printStackTrace();
                    System.out.println("in htttp catch.......22222");
                }
            }
            System.out.println("69696666666666666666666666666666666");
            return null;
        }

        @Override
        protected void onPostExecute(Bitmap bitmap) {
            System.out.println(bitmap);
            displayPopupImage(bitmap);
            //super.onPostExecute(bitmap);
        }
    }
}
