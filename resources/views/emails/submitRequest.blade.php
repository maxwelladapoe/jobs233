@component('mail::message')
# Request from Website
---

### Selected User Type:
```
{{$requestDetails['user_type']}}
```

### Senders Email:
```
{{$requestDetails['email']}}
```

### Subject:
```
{{$requestDetails['subject']}}
```

### Description:
```
{{$requestDetails['description']}}
```

@endcomponent
