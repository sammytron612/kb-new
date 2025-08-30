<x-mail::message>
# Your Article Has Been Approved!

Hello **{{ $author->name }}**,

Great news! Your article has been reviewed and **approved** by admin.

<x-mail::panel>
## {{ $article->title }}

**Status: **Approved**


**Approved on:** {{ now()->format('M j, Y \a\t g:i A') }}
**Article KB:** `{{ $article->kb }}


</x-mail::panel>

Your article is now **live** and accessible to all knowledge base users. Thank you for contributing valuable content to our knowledge base!

<x-mail::button :url="$articleUrl" color="success">
View Published Article
</x-mail::button>

## What's Next?

- Your article is now searchable in the knowledge base
- Other users can view, comment, and share your content
- You'll receive notifications if users have questions or feedback


Thank you for your contribution to the knowledge base!

Best regards,<br>
Admin

<x-mail::subcopy>
You're receiving this email because you authored an article that has been approved for publication.

</x-mail::subcopy>
</x-mail::message>
