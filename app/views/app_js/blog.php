<script type="text/javascript">
   class Blog {
      constructor() {
         this.run();
      }

      run() {
         callApi("blog", {
            slug: "<?php echo $slug; ?>"
         }, e => {
            console.log(e);

            if(e.Data.length == 0) {
               window.location="<?php echo base_url('') ?>";
            }

            $.each(e.Data, function (index, value) { 
                $("h6.blog--title").html(value.title);
                $("small.blog--description").html(value.created_at);
                $("div.blog--thumbnail img").attr('src', value.banner);
                $("div.blog--body").html(value.body);
            });
         })
      }
   }

   new Blog;

   const jsSocials = {
         shares: ["email", "twitter", "facebook", "googleplus", "linkedin", "pinterest", "stumbleupon", "whatsapp"]
      };
   $("#share").jsSocials(jsSocials);
</script>