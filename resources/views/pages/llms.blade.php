# {{ config('platform.name') }}

> {{ config('platform.entity_sentence') }}

{{ config('platform.name') }} ({{ config('platform.url') }}) offers practical, beginner-friendly online courses on how to make money with AI. It is built for learners in Ghana and the African diaspora, and is open to anyone worldwide. Courses are taught by {{ config('platform.instructor.name') }} — {!! config('platform.instructor.role') !!} ({{ config('platform.instructor.credentials') }}).

## Courses & plans
- Free account: full AI Fundamentals course (beginner, no coding), progress tracking, and preview lessons from other courses.
- AI Member (${{ config('platform.prices.pro') }}/month): adds the AI for Business & Productivity course, the AI tutor on every lesson, and a monthly live Q&A.
- AI Pro (${{ config('platform.prices.elite') }}/month): adds the Advanced AI Strategies course, more daily AI tutor questions, priority support, and a monthly 1-on-1 coaching call.
- Payments: card payments in USD via Stripe (worldwide). Mobile Money and cedi (GHS) pricing for Ghana are planned.
- Refunds: {{ config('platform.legal.refund_days') }}-day money-back guarantee on your first payment for any paid plan; cancel anytime and keep access to the end of the billing period.

## Key pages
- Home: {{ config('platform.url') }}/
- Courses: {{ route('courses.index') }}
- Membership & pricing: {{ route('membership.index') }}
- About & instructor: {{ route('about') }}
- FAQ: {{ route('faq') }}
- Contact: {{ route('contact') }}

## Policies
- Terms of Service: {{ route('terms') }}
- Privacy Policy: {{ route('privacy') }}
- Refund Policy: {{ route('refund') }}

## Contact
- Email: {{ config('platform.contact.email') }}
- YouTube: {{ config('platform.instructor.youtube') }}
