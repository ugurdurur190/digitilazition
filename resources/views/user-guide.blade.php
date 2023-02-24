@extends('layouts.menu')
@section('content')

<h1>Kullanım Kılavuzu:</h1>
<hr color="#660066;"/>
<div class="row rounded" style="background-color: #FFFFFF;">

    
    <div class="col-7">
        <!-- Admin User Guide -->
        @if(Auth::user()->privilege_id == 1)
            <h3 style="color:#660066;">"Admin Kullanıcısı" İçin Kullanım Kılavuzu:</h3><br/>
            <h3 style="color:#660066;">Hesap Bilgilerini Düzenle:</h3>
            <hr color="#660066;"/>
            <p>"Hesap Bilgilerini Düzenle" kısmında isim,e-posta ve şifre bilgilerinizi düzenleyebilirsiniz.</p>
            <p>"Yardım" kısmına tıklayınca açılan e-posta hesabına sorularınızı gönderebilirsiniz.</p>
            <div class="col-4"><img src="{{ asset('assets/img/admin_user_guide/user_setting.png') }}" alt=""></div>

            <h3 style="color:#660066;">Kullanıcılar:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/admin_user_guide/user_list.png') }}" alt=""></div>
            <p>-Menüde ki "Kullanıcılar" kısmında, kullanıcı ekleme,düzenleme ve silme işlemleri gerçekleştirilir.</p>
            <h5 style="color:#8B0000;">Yeni kullanıcı ekle:</h5>
            <div class="col-4"><img src="{{ asset('assets/img/admin_user_guide/new_user.png') }}" alt=""></div>
            <p>-Sistemde 5 tür kullanıcı türü vardır.</p>
            <p>-<b>"Admin"</b> olan kullanıcıların diğer kullanıcılardan farklı olarak yeni kullanıcı ekleme,düzenleme,silme işlemlerini gerçekleştirir. Kullanıcıların proje fikirlerini girebileceği proje formları oluşturur.
                Ve bir projenin değerlendirme anketi oylamaya açılmadan bu ankete soru ekleyebilir ve çıkartabilir.
            </p>
            <p>-<b>"Personel"</b> olan kullanıcılar proje formlarını doldurup gönderebilir. Projeleri oylayabilir. Projelerde çalışabilir.</p>
            <p>-<b>"Yönetici"</b> olan kullanıcılar proje formlarını doldurup gönderebilir. Projeleri oylayabilir. Projelerde çalışabilir. Bu kullanıcının oyu diğer kullanıcılara göre 10 kat daha etkilidir.</p>
            <p>-<b>"Birim Yöneticisi"</b> olan kullanıcılar eğer bir projenin etkilenen birimlerinden ise kendi birimlerinin proje onayını verebilirler. Eğer birim yöneticisi birim onayını vermezse proje oylamaya açılamaz. Ve proje formlarını doldurup gönderebilir. Projeleri oylayabilir. Projelerde çalışabilir.</p>
            <p>-<b>"Developer"</b> olan kullanıcılar sadece proje alanında çalışabilirler. Proje formunu dolduramaz ve oylamalara katılamazlar.</p>
            <h5 style="color:#8B0000;">Kullanıcı düzenle ve sil:</h5>
            <p>Kullanıcı listesinde ki <b>"Aksiyon"</b> alanında kullanıcı düzenleme ve silme butonlarına basılarak işlem yapılır.</p>
            <p><i style="color: black;" class="fa fa-edit fa-lg"></i> butonuna basınca kullanıcının isim,email,şifre ve kullanıcı türü düzenlenebilir.</p>
            <br/>
            <h3 style="color:#660066;">Proje Formu:</h3>
            <hr color="#660066;"/>
            <p>Proje fikirlerinizi "Proje Formunu" doldurarak gönderebilirsiniz. Projeden "Etkilenen Birimler" projeyi onaylarsa projeniz oylamaya açılacaktır.</p>
            <div class="col-4"><img src="{{ asset('assets/img/admin_user_guide/project_forms.png') }}" alt=""></div>
            <p>"<i style="color: black;" class="fa fa-plus"></i> YENİ FORM OLUŞTUR" butonuna basınca açılan sayfada form ismini,açıklamasını ve başlangıç-bitiş tarihlerini girerek yeni form oluşturabilirsiniz. Proje formlarını sadece Admin oluşturabilir,düzenleyebilir ve silebilir.</p>
            <p><i style="color: black;" class="fa fa-edit fa-lg"></i> butonuna basınca form ismini,açıklamasını ve başlangıç-bitiş tarihlerini düzenleyebilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Formuna" soru ve mevcut süreçler ekleyebilir,soruları kaldırabilirsiniz.</p>
            <div class="col-4"><img src="{{ asset('assets/img/admin_user_guide/project_form_view.png') }}" alt=""></div><br/>
            <p>"<i style="color:black;" class="fa fa-plus fa-lg"> Yeni Soru Oluştur</i>" butonuna basınca açılan pencereden 3 tür soru tipi ekleyebilirsiniz.</p>
            <p>"<i style="color:black;" class="fa fa-plus fa-lg"> Mevcut Süreç Oluştur</i>" butonuna basınca açılan pencereden "Mevcut Süreç" ekleyebilirsiniz.</p>
            <h3 style="color:#660066;">Proje Anketi:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/admin_user_guide/project_vote.png') }}" alt=""></div><br/>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Formuna" girilen bilgileri görebilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-edit fa-lg"></i> butonuna basınca açılan sayfada "Etkilenen Birim Onaylarını" "Admin" olarak görebilirsiniz. Birim onaylarını sadece ilgili "Birim Yönetici" verebilir. </p>
            <p><i style="color: black;" class="fa fa-cog fa-lg"></i> butonuna basınca açılan sayfada "Proje Değerelendirme Anketine" soru ekleyebilir,soru kaldırabilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-check fa-lg"></i> butonuna basınca açılan sayfada "Proje Değerelendirme Anketini" doldurarak projeyi oylayabilirsiniz.</p>
            <h3 style="color:#660066;">Proje Anket Sonucu:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/admin_user_guide/project_report.png') }}" alt=""></div><br/>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Değerlendirme Anketinin" oylanma oranını görebilirsiniz.</p>
            <h3 style="color:#660066;">Proje Çalışma Alanı:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/admin_user_guide/project_work_field.png') }}" alt=""></div><br/>
            <p><a class="btn btn-block btn-sm btn-default btn-flat " style="background-color: #660066; color:white;">Çalışma Alanı</a> butonuna basınca açılan sayfada proje çalışma durumunu, verilen görevleri görebilirsiniz.
            Ve proje grubunda iseniz grup üyelerine görev verebilirsiniz.</p>
            <p><a class="btn btn-block btn-sm btn-default btn-flat " style="background-color: #660066; color:white;">Çalışma Takımı</a> butonuna basınca açılan sayfada, eğer grup yetkilisi iseniz sistem kullanıcılarını grup üyesi veya grup yetkilisi yapabilirsiniz.
            Grup üyelerini gruptan atabilir ve grup üyelerinin yetkisini geri alabilirsiniz.<p>
            <h3 style="color:#660066;">Dashboard:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/admin_user_guide/project_graphic.png') }}" alt=""></div><br/>
            <p>Dashboard sayfasında projelerin pasta grafiğini ve değerlendirme oranını görebilirsiniz.</p>
            <p>"Kullanıcı Oy Bilgisi" kısmında projelerin oylanma durumunu da görebilirsiniz.</p>
            <p>Ayrıca birimlere göre proje dağılımlarının sütun grafiğini görebilirsiniz.</p>
        @endif



        <!-- Staff User Guide -->
        @if(Auth::user()->privilege_id == 2)
            <h3 style="color:#660066;">"Personel Kullanıcısı" İçin Kullanım Kılavuzu:</h3><br/>
            <h3 style="color:#660066;">Hesap Bilgilerini Düzenle:</h3>
            <hr color="#660066;"/>
            <p>"Hesap Bilgilerini Düzenle" kısmında isim,e-posta ve şifre bilgilerinizi düzenleyebilirsiniz.</p>
            <p>"Yardım" kısmına tıklayınca açılan e-posta hesabına sorularınızı gönderebilirsiniz.</p>
            <div class="col-4"><img src="{{ asset('assets/img/staff_user_guide/user_setting.png') }}" alt=""></div><br/>

            <h3 style="color:#660066;">Proje Formu:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/staff_user_guide/project_forms.png') }}" alt=""></div><br/>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna tıklayarak "Proje Formuna" erişebilirsiniz.</p>
            <p>Proje fikirlerinizi "Proje Formunu" doldurarak gönderebilirsiniz. Projeden "Etkilenen Birimler" projeyi onaylarsa projeniz oylamaya açılacaktır.</p><br/>

            <h3 style="color:#660066;">Proje Anketi:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/staff_user_guide/project_vote.png') }}" alt=""></div><br/>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Formuna" girilen bilgileri görebilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-check fa-lg"></i> butonuna basınca açılan sayfada "Proje Değerelendirme Anketini" doldurarak projeyi oylayabilirsiniz.</p><br/>

            <h3 style="color:#660066;">Proje Anket Sonucu:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/staff_user_guide/project_report.png') }}" alt=""></div><br/>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Değerlendirme Anketinin" oylanma oranını görebilirsiniz.</p><br/>
        
            <h3 style="color:#660066;">Proje Çalışma Alanı:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/staff_user_guide/project_work.png') }}" alt=""></div><br/>
            <p><a class="btn btn-block btn-sm btn-default btn-flat " style="background-color: #660066; color:white;">Çalışma Alanı</a> butonuna basınca açılan sayfada proje çalışma durumunu, verilen görevleri görebilirsiniz.
            Ve proje grubunda iseniz grup üyelerine görev verebilirsiniz.</p>
            <p><a class="btn btn-block btn-sm btn-default btn-flat " style="background-color: #660066; color:white;">Çalışma Takımı</a> butonuna basınca açılan sayfada, eğer grup yetkilisi iseniz sistem kullanıcılarını grup üyesi veya grup yetkilisi yapabilirsiniz.
            Grup üyelerini gruptan atabilir ve grup üyelerinin yetkisini geri alabilirsiniz.<p><br/>

            <h3 style="color:#660066;">Dashboard:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/staff_user_guide/project_graphic.png') }}" alt=""></div><br/>
            <p>Dashboard sayfasında projelerin pasta grafiğini ve değerlendirme oranını görebilirsiniz.</p>
            <p>"Kullanıcı Oy Bilgisi" kısmında projelerin oylanma durumunu da görebilirsiniz.</p>
            <p>Ayrıca birimlere göre proje dağılımlarının sütun grafiğini görebilirsiniz.</p>
        
        @endif


        <!-- Subscriber (Manager) User Guide -->
        @if(Auth::user()->privilege_id == 3)
            <h3 style="color:#660066;">"Yönetici Kullanıcısı" İçin Kullanım Kılavuzu:</h3><br/>
            <h3 style="color:#660066;">Hesap Bilgilerini Düzenle:</h3>
            <hr color="#660066;"/>
            <p>"Hesap Bilgilerini Düzenle" kısmında isim,e-posta ve şifre bilgilerinizi düzenleyebilirsiniz.</p>
            <p>"Yardım" kısmına tıklayınca açılan e-posta hesabına sorularınızı gönderebilirsiniz.</p>
            <div class="col-4"><img src="{{ asset('assets/img/subscriber_user_guide/user_setting.png') }}" alt=""></div><br/>

            <h3 style="color:#660066;">Proje Formu:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/subscriber_user_guide/project_forms.png') }}" alt=""></div><br/>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna tıklayarak "Proje Formuna" erişebilirsiniz.</p>
            <p>Proje fikirlerinizi "Proje Formunu" doldurarak gönderebilirsiniz. Projeden "Etkilenen Birimler" projeyi onaylarsa projeniz oylamaya açılacaktır.</p><br/>

            <h3 style="color:#660066;">Proje Anketi:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/subscriber_user_guide/project_vote.png') }}" alt=""></div><br/>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Formuna" girilen bilgileri görebilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-check fa-lg"></i> butonuna basınca açılan sayfada "Proje Değerelendirme Anketini" doldurarak projeyi oylayabilirsiniz.</p>
            <p>"Yönetici Kullanıcısı" olarak verdiğiniz oy diğer kullancıılara göre 10 kat daha etkilidir. </p><br/>

            <h3 style="color:#660066;">Proje Anket Sonucu:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/subscriber_user_guide/project_report.png') }}" alt=""></div><br/>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Değerlendirme Anketinin" oylanma oranını görebilirsiniz.</p><br/>
        
            <h3 style="color:#660066;">Proje Çalışma Alanı:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/subscriber_user_guide/project_work.png') }}" alt=""></div><br/>
            <p><a class="btn btn-block btn-sm btn-default btn-flat " style="background-color: #660066; color:white;">Çalışma Alanı</a> butonuna basınca açılan sayfada proje çalışma durumunu, verilen görevleri görebilirsiniz.
            Ve proje grubunda iseniz grup üyelerine görev verebilirsiniz.</p>
            <p><a class="btn btn-block btn-sm btn-default btn-flat " style="background-color: #660066; color:white;">Çalışma Takımı</a> butonuna basınca açılan sayfada, eğer grup yetkilisi iseniz sistem kullanıcılarını grup üyesi veya grup yetkilisi yapabilirsiniz.
            Grup üyelerini gruptan atabilir ve grup üyelerinin yetkisini geri alabilirsiniz.<p><br/>

            <h3 style="color:#660066;">Dashboard:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/subscriber_user_guide/project_graphic.png') }}" alt=""></div><br/>
            <p>Dashboard sayfasında projelerin pasta grafiğini ve değerlendirme oranını görebilirsiniz.</p>
            <p>"Kullanıcı Oy Bilgisi" kısmında projelerin oylanma durumunu da görebilirsiniz.</p>
            <p>Ayrıca birimlere göre proje dağılımlarının sütun grafiğini görebilirsiniz.</p>
        
        @endif


        <!-- UnitSubscriber (Unit Manager) User Guide -->
        @if(Auth::user()->privilege_id == 4)
            <h3 style="color:#660066;">"Birim Yönetici Kullanıcısı" İçin Kullanım Kılavuzu:</h3><br/>
            <h3 style="color:#660066;">Hesap Bilgilerini Düzenle:</h3>
            <hr color="#660066;"/>
            <p>"Hesap Bilgilerini Düzenle" kısmında isim,e-posta ve şifre bilgilerinizi düzenleyebilirsiniz.</p>
            <p>"Yardım" kısmına tıklayınca açılan e-posta hesabına sorularınızı gönderebilirsiniz.</p>
            <div class="col-4"><img src="{{ asset('assets/img/unit_subscriber_user_guide/user_setting.png') }}" alt=""></div><br/>

            <h3 style="color:#660066;">Proje Formu:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/unit_subscriber_user_guide/project_forms.png') }}" alt=""></div><br/>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna tıklayarak "Proje Formuna" erişebilirsiniz.</p>
            <p>Proje fikirlerinizi "Proje Formunu" doldurarak gönderebilirsiniz. Projeden "Etkilenen Birimler" projeyi onaylarsa projeniz oylamaya açılacaktır.</p><br/>

            <h3 style="color:#660066;">Proje Anketi:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/unit_subscriber_user_guide/project_vote.png') }}" alt=""></div><br/>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Formuna" girilen bilgileri görebilirsiniz.</p>
            <p><i style="color: black;" class="fa fa-edit fa-lg"></i> butonuna basınca açılan sayfada "Etkilenen Birim Onaylarını" "Birim Yöneticisi" olarak görebilirsiniz. Birim onaylarını sadece ilgili "Birim Yönetici" verebilir. </p>
            <p><i style="color: black;" class="fa fa-check fa-lg"></i> butonuna basınca açılan sayfada "Proje Değerelendirme Anketini" doldurarak projeyi oylayabilirsiniz.</p><br/>

            <h3 style="color:#660066;">Proje Anket Sonucu:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/unit_subscriber_user_guide/project_report.png') }}" alt=""></div><br/>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Değerlendirme Anketinin" oylanma oranını görebilirsiniz.</p><br/>
        
            <h3 style="color:#660066;">Proje Çalışma Alanı:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/unit_subscriber_user_guide/project_work.png') }}" alt=""></div><br/>
            <p><a class="btn btn-block btn-sm btn-default btn-flat " style="background-color: #660066; color:white;">Çalışma Alanı</a> butonuna basınca açılan sayfada proje çalışma durumunu, verilen görevleri görebilirsiniz.
            Ve proje grubunda iseniz grup üyelerine görev verebilirsiniz.</p>
            <p><a class="btn btn-block btn-sm btn-default btn-flat " style="background-color: #660066; color:white;">Çalışma Takımı</a> butonuna basınca açılan sayfada, eğer grup yetkilisi iseniz sistem kullanıcılarını grup üyesi veya grup yetkilisi yapabilirsiniz.
            Grup üyelerini gruptan atabilir ve grup üyelerinin yetkisini geri alabilirsiniz.<p><br/>

            <h3 style="color:#660066;">Dashboard:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/unit_subscriber_user_guide/project_graphic.png') }}" alt=""></div><br/>
            <p>Dashboard sayfasında projelerin pasta grafiğini ve değerlendirme oranını görebilirsiniz.</p>
            <p>"Kullanıcı Oy Bilgisi" kısmında projelerin oylanma durumunu da görebilirsiniz.</p>
            <p>Ayrıca birimlere göre proje dağılımlarının sütun grafiğini görebilirsiniz.</p>
        
        @endif


        <!-- Developer User Guide -->
        @if(Auth::user()->privilege_id == 5)
            <h3 style="color:#660066;">"Developer" İçin Kullanım Kılavuzu:</h3><br/>
            <h3 style="color:#660066;">Hesap Bilgilerini Düzenle:</h3>
            <hr color="#660066;"/>
            <p>"Hesap Bilgilerini Düzenle" kısmında isim,e-posta ve şifre bilgilerinizi düzenleyebilirsiniz.</p>
            <p>"Yardım" kısmına tıklayınca açılan e-posta hesabına sorularınızı gönderebilirsiniz.</p>
            <div class="col-4"><img src="{{ asset('assets/img/developer_user_guide/user_setting.png') }}" alt=""></div><br/>


            <h3 style="color:#660066;">Proje Anketi:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/developer_user_guide/project_vote.png') }}" alt=""></div><br/>
            <p><i style="color: black;" class="fa fa-eye fa-lg"></i> butonuna basınca açılan sayfada "Proje Formuna" girilen bilgileri görebilirsiniz.</p><br/>

        
            <h3 style="color:#660066;">Proje Çalışma Alanı:</h3>
            <hr color="#660066;"/>
            <div class="col-4"><img src="{{ asset('assets/img/developer_user_guide/project_work.png') }}" alt=""></div><br/>
            <p><a class="btn btn-block btn-sm btn-default btn-flat " style="background-color: #660066; color:white;">Çalışma Alanı</a> butonuna basınca açılan sayfada proje çalışma durumunu, verilen görevleri görebilirsiniz.
            Ve proje grubunda iseniz grup üyelerine görev verebilirsiniz.</p>
            <p><a class="btn btn-block btn-sm btn-default btn-flat " style="background-color: #660066; color:white;">Çalışma Takımı</a> butonuna basınca açılan sayfada, eğer grup yetkilisi iseniz sistem kullanıcılarını grup üyesi veya grup yetkilisi yapabilirsiniz.
            Grup üyelerini gruptan atabilir ve grup üyelerinin yetkisini geri alabilirsiniz.<p><br/>

        
        @endif
       
    </div>

</div>

@endsection